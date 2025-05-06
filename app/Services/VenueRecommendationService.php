namespace App\Services;

use App\Models\Venue;
use App\Models\SurveyResponse;
use Illuminate\Support\Facades\Auth;

class VenueRecommendationService
{
    public function getRecommendedVenues()
    {
        $user = Auth::user();
        $response = $user->surveyResponse;

        if (!$response) {
            return Venue::all(); // fallback
        }

        $venues = Venue::all();

        // Assign a score to each venue based on similarity
        $scored = $venues->map(function ($venue) use ($response) {
            $score = 0;

            if (strtolower($venue->event_type) === strtolower($response->event_type)) {
                $score += 3;
            }

            // Allow margin in guest capacity (+/- 20)
            if (abs($venue->guest_capacity - $response->guest_capacity) <= 20) {
                $score += 2;
            }

            if (strtolower($venue->ambience) === strtolower($response->ambience)) {
                $score += 1;
            }

            $venue->score = $score;
            return $venue;
        });

        // Sort by score (descending)
        return $scored->sortByDesc('score')->values();
    }
}
