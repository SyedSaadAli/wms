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
        // If vendor ID is present, show only that vendor's venues
        if ($id) {
            $profile = Profile::find($id);
            $data['venues'] = Venue::where('user_id', $profile->user_id)->get();
            return view('venues', $data);
        }

        // If no vendor ID, check for user and survey
        $user = Auth::user();

        // Not logged in or survey not filled: show all venues
        if (!$user || !$user->survey) {
            $data['venues'] = Venue::all();
            return view('venues', $data);
        }

        // Logged in and survey filled: generate user-specific recommendation files
        $userId = $user->id;
        $aiDir = public_path("ai/user_$userId");
        if (!file_exists($aiDir)) {
            mkdir($aiDir, 0777, true);
        }

        // Export venues and survey for this user
        $this->exportVenuesForUser($aiDir);
        $this->exportSurveyForUser($aiDir);

        // Run Python script for this user
        $process = new \Symfony\Component\Process\Process([
            'python3',
            public_path('ai/recommendation_model.py'),
            $aiDir // Pass the user-specific directory as an argument
        ]);
        $process->run();

        if ($process->isSuccessful()) {
            $output = trim($process->getOutput());
            $recommendedIds = array_filter(explode(',', $output));
            $data['venues'] = Venue::whereIn('id', $recommendedIds)
                ->orderByRaw("FIELD(id, " . implode(',', $recommendedIds) . ")")
                ->get();
        } else {
            // fallback to all venues if AI fails
            $data['venues'] = Venue::all();
        }

        return view('venues', $data);
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

    // Export venues for a specific user
    public function exportVenuesForUser($dir)
    {
        $venues = Venue::all();
        $venuesCsv = fopen($dir . '/venues.csv', 'w');
        fputcsv($venuesCsv, ['id', 'event_type', 'guest_capacity', 'ambience']);
        foreach ($venues as $venue) {
            fputcsv($venuesCsv, [$venue->id, $venue->event_type, $venue->guest_capacity, $venue->ambience]);
        }
        fclose($venuesCsv);
    }

    // Export survey for a specific user
    public function exportSurveyForUser($dir)
    {
        $survey = Auth::user()->surveyResponse;
        $surveyCsv = fopen($dir . '/user_survey.csv', 'w');
        fputcsv($surveyCsv, ['event_type', 'guest_capacity', 'ambience']);
        fputcsv($surveyCsv, [$survey->event_type, $survey->guest_capacity, $survey->ambience]);
        fclose($surveyCsv);
    }
}
