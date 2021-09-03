<?php

class Model_Testabl extends Model
{

    /**
     * @var $stmt Zend_DB_Statement
     */
    public $stmt;
    public $db;

	public function __construct()
	{
		  $this->db = Zend_Registry::get('db');
	}



    public function getTestCount($userData, $job_id)
    {
        $count = 0;
        $count = $count+count($this->getUnGradedTests($userData, $job_id));
        $count  = $count+count($this->getGradedTests($userData, $job_id));
        $count  = $count+count($this->getUnGradedExcelTests($userData, $job_id));
        $count  = $count+count($this->getGradedExcelTests($userData, $job_id));

        return $count;
    }

    public function getUnGradedTests($user_id, $job_id){

        $sql = "select DISTINCT link_name, link_url from classmarker_links cl
                inner join employers_tests et on et.link_id = cl.link_id and et.job_id = ?
                left join classmarker_link_results clr on clr.link_id = cl.link_id and clr.cm_user_id = ?
                where  clr.cm_user_id is NULL;";

        $this->stmt = $this->db->query($sql,
            array($job_id,$user_id));
        return $this->stmt->fetchAll();
    }

    public function getGradedTests($user_id, $job_id){
        $sql = "select DISTINCT link_name, link_url from classmarker_links cl
                inner join employers_tests et on et.link_id = cl.link_id and et.job_id = ?
                left join classmarker_link_results clr on clr.link_id = cl.link_id
                where  clr.cm_user_id = ?";

        $this->stmt = $this->db->query($sql,
            array($job_id, $user_id));
        return $this->stmt->fetchAll();
    }

    public function getGradedExcelTests($user_id, $job_id)
    {
        $sql = "select name from excel_tests et
                inner join excel_test_results etr on etr.test_id = et.test_id
                inner join excel_tests_jobs etj on et.test_id = etj.test_id
                where etr.user_id = ? and etj.job_id = ?;";

        $this->stmt = $this->db->query($sql, array($user_id, $job_id));
        return $this->stmt->fetchAll();
    }

    public function getUnGradedExcelTests($user_id, $job_id)
    {

        $sql = "select et.test_id, et.name from excel_tests et
                left join excel_test_results etr on etr.test_id = et.test_id and etr.user_id = ?
                inner join excel_tests_jobs etj on et.test_id = etj.test_id
                where etr.user_id is null and etj.job_id = ? ";

        $this->stmt = $this->db->query($sql, array($user_id, $job_id));
        return $this->stmt->fetchAll();
    }

    public function saveExcelTestResults($test_id, $user_id, $time, $correct, $incorrect)
    {
        $sql = "SELECT IF(EXISTS(select test_id from excel_test_results where test_id = ? and user_id = ?), 1,0)";
        $this->stmt = $this->db->query($sql, array($test_id, $user_id ));
        $result = $this->stmt->fetchColumn(0);
        if($result == 0){
            $sql = "INSERT INTO excel_test_results (test_id, user_id, time_elapsed, correct_words, incorrect_words) VALUES (?,?,?,?,?)";
            $this->db->query($sql, array($test_id, $user_id, $time, $correct, $incorrect));
        }
    }

    public function getUsersTestResults($user_id, $employer_id)
    {
        $params = array();
        $params[] = $employer_id;

        $sql = "select j.title, u.firstname, u.surname, cl.link_name, points_scored, points_available,
                DATE_FORMAT(FROM_UNIXTIME(time_started), '%d-%m-%Y %H:%i:%s') as time_started,  
                DATE_FORMAT(FROM_UNIXTIME(time_finished), '%d-%m-%Y %H:%i:%s') as time_finished, 
                duration from classmarker_link_results clr
                inner join classmarker_links cl on cl.link_id = clr.link_id
                inner join users u on u.id = clr.cm_user_id
                inner join users_job uj on uj.user_id = clr.cm_user_id
                inner join jobs j on j.uniqueid = uj.job_id
                where j.employer_id = ?";
        if($user_id > 0)
        {
            $params[] = $user_id;
            $sql .= "and clr.cm_user_id = ?";
        }
        $sql .= "GROUP BY cl.link_name, points_scored, points_available, time_started,time_finished, duration";
        return $this->db->query($sql, $params)->fetchAll();
    }

    public function getTestName($test) {
        $word = '';
        switch($test){
            case 0:$word = "zero";break;
            case 1:$word = "one";break;
            case 2:$word = "two";break;
            case 3:$word = "three";break;
            case 4:$word = "four";break;
            case 5:$word = "five";break;
            case 6:$word = "six";break;
            case 7:$word = "seven";break;
            case 8:$word = "eight";break;
            case 9:$word = "nine";break;
            case 10:$word = "ten";break;
            case 11:$word = "eleven";break;
            case 12:$word = "twelve";break;
            case 13:$word = "thirteen";break;
            case 14:$word = "fourteen";break;
            case 15:$word = "fifteen";break;
            case 16:$word = "sixteen";break;
            case 17:$word = "seventeen";break;
            case 18:$word = "eighteen";break;
            case 19:$word = "nineteen";break;
        }
        if (strlen($word) > 0)
            return 'test' . ucfirst($word);

        if (strlen($test) == 2) {
            switch(substr($test, 0, 1)){
                case 2:$word = "twenty";break;
                case 3:$word = "thirty";break;
                case 4:$word = "fourty";break;
                case 5:$word = "fifty";break;
                case 6:$word = "sixty";break;
                case 7:$word = "seventy";break;
                case 8:$word = "eighty";break;
                case 9:$word = "ninety";break;
            }
            switch(substr($test, 1, 1)){
                case 1:$word .= "One";break;
                case 2:$word .= "Two";break;
                case 3:$word .= "Three";break;
                case 4:$word .= "Four";break;
                case 5:$word .= "Five";break;
                case 6:$word .= "Six";break;
                case 7:$word .= "Seven";break;
                case 8:$word .= "Eight";break;
                case 9:$word .= "Nine";break;
            }
        }
        return $word;
    }

    public function secureString($s) {
        return strip_tags($s);
    }

}
