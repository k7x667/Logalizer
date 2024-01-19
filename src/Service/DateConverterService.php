<?php 

namespace App\Service;

/**
 * Class DateConverterService
 *
 * A service for converting date strings to Unix timestamps.
 */
class DateConverterService
{
    /**
     * @var array Mapping of month abbreviations to numerical representation.
     */
    private $monthMap = [
        'Jan' => '01',
        'Feb' => '02',
        'Mar' => '03',
        'Apr' => '04',
        'May' => '05',
        'Jun' => '06',
        'Jul' => '07',
        'Aug' => '08',
        'Sep' => '09',
        'Oct' => '10',
        'Nov' => '11',
        'Dec' => '12',
    ];

    /**
     * Converts a date string to a Unix timestamp.
     *
     * @param string $dateString The input date string.
     *
     * @return int|null The Unix timestamp or null if conversion fails.
     */
    public function convertToTimestamp(string $dateString): ?int
    {
        // Extract components from the date string
        if ($dateComponents = $this->extractComponents($dateString)) {
            // Convert the month abbreviation to a numerical representation
            $month = $this->monthMap[$dateComponents['monthAbbrev']];

            // Create the date string in a format supported by strtotime
            $dateFormatted = sprintf(
                "%04d-%02d-%02d %02d:%02d:%02d",
                $dateComponents['year'],
                $month,
                $dateComponents['day'],
                $dateComponents['hour'],
                $dateComponents['minute'],
                $dateComponents['second']
            );

            // Convert the formatted date string to a Unix timestamp
            return strtotime($dateFormatted);
        }

        // Return null if conversion fails
        return null;
    }

    /**
     * Extracts components from the date string.
     *
     * @param string $dateString The input date string.
     *
     * @return array|null Associative array of date components or null if extraction fails.
     */
    private function extractComponents(string $dateString): ?array
    {
        // Extract components from the date string
        if (sscanf($dateString, "%d/%[^/]/%d:%d:%d:%d", $day, $monthAbbrev, $year, $hour, $minute, $second) === 6) {
            return [
                'day' => $day,
                'monthAbbrev' => $monthAbbrev,
                'year' => $year,
                'hour' => $hour,
                'minute' => $minute,
                'second' => $second,
            ];
        }

        // Return null if extraction fails
        return null;
    }

    /**
     * Converts a Unix timestamp to a date string with the format "d/m/Y - H:i".
     *
     * @param int $timestamp The Unix timestamp.
     *
     * @return string The formatted date string.
     */
    public function convertToFormattedDate(int $timestamp): string
    {
        return date('d/m/Y|H:i:s', $timestamp);
    }
}
