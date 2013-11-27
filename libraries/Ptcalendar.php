<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ptcalendar {

    /**
     * Current selected year
     * @var int
     */
    private $_selected_year;

    /**
     * Current selected month
     * @var int
     */
    private $_selected_month;

    /**
     * CodeIgniter object
     * @var object
     */
    private $CI;

    /**
     * Day of week format, set in config file
     * @var string
     */
    private $day_of_week_format;

    /**
     * Month format, set in config file
     * @var string
     */
    private $month_format;

    /**
     * Year format, set in config file
     * @var string
     */
    private $year_format;

    /**
     * Constructor
     *
     * @access	public
     * @param	array	initialization parameters
     */
    public function __construct($config = array()) {

        $this->CI = &get_instance();

        if (!empty($config)) {
            $this->initialize($config);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Initialize Preferences
     *
     * @access	public
     * @param	array	initialization parameters
     * @return	void
     */
    private function initialize($config = array()) {
        foreach($config as $k => $v) {
            $this->{$k} = $v;
        }
    }

    /**
     * Generate a calendar and output the data
     * @param int $year
     * @param int $month
     * @param array $events
     * @return string
     */
    public function generate($year = NULL, $month = NULL, $events = array(), $uriPath = 'calendar/show/', $templatePath = 'calendar/') {
        // Set month and year
        if (is_null($year))
            $year = date("Y", time());

        if (is_null($month))
            $month = date("m", time());


        $this->_selected_year = $year;
        $this->_selected_month = $month;

        $header = self::generate_header($uriPath);
        $body = self::generate_body($events);


        $data = array_merge($header, $body);

        return $this->CI->load->view($templatePath.'calendar_template_view', $data);
    }

    /**
     * Generates the header
     * @return array
     */
    private function generate_header($uriPath) {
        $header = array();

        // Set the selected month and year
        $header['month'] = strftime($this->month_format, mktime(0,0,0,$this->_selected_month,1,0));
        $header['year'] = strftime($this->year_format, mktime(0,0,0,1,1,$this->_selected_year));

        if($this->_selected_month == 12 || $this->_selected_month == 1) {
            if($this->_selected_month == 12) {
                $header['next_link'] = site_url($uriPath.($this->_selected_year + 1).'/1');
                $header['previous_link'] = site_url($uriPath.$this->_selected_year.'/'.($this->_selected_month - 1));
            } else {
                $header['next_link'] = site_url($uriPath.$this->_selected_year.'/'.($this->_selected_month + 1));
                $header['previous_link'] = site_url($uriPath.($this->_selected_year - 1).'/12');
            }
        } else {
            $header['next_link'] = site_url($uriPath.$this->_selected_year.'/'.($this->_selected_month + 1));
            $header['previous_link'] = site_url($uriPath.$this->_selected_year.'/'.($this->_selected_month - 1));
        }

        // Set the days of the week. Using locale.
        $header['daysofweek'] = array();
        $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        foreach ($daysOfWeek as $day) {
            $header['daysofweek'][] = strftime($this->day_of_week_format, strtotime("last $day"));
        }

        return $header;
    }

    /**
     * Generates the body
     * @return array
     */
    private function generate_body($events = array()) {
        $body = array();

        // Determine the total days in the month
        $totalDays = cal_days_in_month(CAL_GREGORIAN, $this->_selected_month, $this->_selected_year);

        // Determine which is the first weekday
        $date = new DateTime($this->_selected_year . "-" . $this->_selected_month . "-01");
        $date->modify('first day of');
        $startWeekDay = $date->format('w');



        // Fill our calendar
        $body['weeks'] = array();
        $currentDayNumber = 1 - $startWeekDay; // Find the start
        $weekCounter = 0; // Needed to count the weeks to start new rows
        $dayCounter = 0; // Needed to count the days to start new rows
        while ($currentDayNumber <= $totalDays) {

            // Check if we reached the end of the week. In that case we need a new week
            if ($dayCounter == 7) {
                $dayCounter = 0;
                $weekCounter++;
            }

            // Check if we got a positive number. If not, we got a day from the previous month
            if ($currentDayNumber > 0) {
                // Let's see if we got some data to show.
                if (isset($events[$currentDayNumber])) {
                    $body['weeks'][$weekCounter]['days'][$dayCounter]['day'] = $currentDayNumber;
                    foreach ($events[$currentDayNumber] as $event) {
                        $body['weeks'][$weekCounter]['days'][$dayCounter]['events'][] = $event;
                    }
                } else {
                    $body['weeks'][$weekCounter]['days'][$dayCounter]['day'] = $currentDayNumber;
                }
            } else {
                $body['weeks'][$weekCounter]['days'][$dayCounter]['day'] = '';
            }

            if($currentDayNumber == date('j', time()) && $this->_selected_month == date('n', time()) && $this->_selected_year == date('Y', time())) {
                $body['weeks'][$weekCounter]['days'][$dayCounter]['today'] = TRUE;
            }

            $dayCounter++;
            $currentDayNumber++;
        }

        // Fill the latest gaps with empty dates
        while ($dayCounter < 7) {
            $body['weeks'][$weekCounter]['days'][$dayCounter]['day'] = '';
            $dayCounter++;
        }

        return $body;
    }

}

// EOF