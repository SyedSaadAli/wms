<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        $user = Auth::user();
        if (isset($user) && !$user->survey) {
            $showSurvey = true;
        } else {
            $showSurvey = false;
        }

        return view('home', compact('showSurvey'));
    }

    /**
     * Display the venues page.
     */
    public function venues($id = null)
    {
        if ($id) {
            $profile = Profile::find($id);
            $data['venues'] = Venue::where('user_id', $profile->user_id)->get();
            return view('venues', $data);
        } else {
            $data['venues'] = Venue::all();
            return view('venues', $data);
        }

        // for ai part
        // $user = Auth::user();
        // $data['venues'] = [];

        // if ($user->survey) {
        //     // Export current data for AI
        //     $this->exportVenuesIfNeeded();
        //     $this->exportSurvey();

        //     // Run Python script
        //     $process = new Process(['python3', public_path('ai/recommendation_model.py')]);
        //     $process->run();

        //     if ($process->isSuccessful()) {
        //         $output = trim($process->getOutput());
        //         $recommendedIds = array_filter(explode(',', $output));
        //         $data['venues'] = Venue::whereIn('id', $recommendedIds)
        //                             ->orderByRaw("FIELD(id, " . implode(',', $recommendedIds) . ")")
        //                             ->get();
        //     } else {
        //         // fallback to all venues if AI fails
        //         $data['venues'] = Venue::all();
        //     }
        // } else {
        //     $data['venues'] = Venue::all();
        // }

        // return view('venues', $data);

    }

    public function venueDetails($id){
        $venue = Venue::find($id);
        if (!$venue) {
            return redirect()->route('home')->with('error', 'Venue not found.');
        }
        $data['venue'] = $venue;
        return view('venue_details',$data);
    }

    /**
     * Display the vendors page.
     */
    public function vendors()
    {
        $data['businessProfile'] = Profile::all();
        return view('vendors', $data);
    }

    public function submitSurvey(Request $request)
    {
        $user = Auth::user();
        SurveyResponse::create([
            'user_id' => $user->id,
            'event_type' => $request->event_type,
            'guest_capacity' => $request->guest_capacity,
            'ambience' => $request->ambience,
        ]);

        $user->survey = 1;
        $user->save();

        return redirect()->route('home')->with('success', 'Thanks for submitting your preferences!');
    }
    public function exportVenues()
    {
        $venues = Venue::all();
        $venuesCsv = fopen(public_path('ai/venues.csv'), 'w');
        fputcsv($venuesCsv, ['id', 'event_type', 'guest_capacity', 'ambience']);
        foreach ($venues as $venue) {
            fputcsv($venuesCsv, [$venue->id, $venue->event_type, $venue->guest_capacity, $venue->ambience]);
        }
        fclose($venuesCsv);
    }

    public function exportSurvey()
    {
        $survey = Auth::user()->surveyResponse;
        $surveyCsv = fopen(public_path('ai/user_survey.csv'), 'w');
        fputcsv($surveyCsv, ['event_type', 'guest_capacity', 'ambience']);
        fputcsv($surveyCsv, [$survey->event_type, $survey->guest_capacity, $survey->ambience]);
        fclose($surveyCsv);
    }
    public function exportVenuesIfNeeded()
    {
        $csvPath = public_path('ai/venues.csv');
        $lastExported = file_exists($csvPath) ? filemtime($csvPath) : 0;
        $lastVenueUpdate = \App\Models\Venue::max('updated_at')->timestamp;

        if ($lastVenueUpdate > $lastExported) {
            $this->exportVenues();
        }
    }

}
