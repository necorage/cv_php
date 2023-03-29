<?php
require_once "dbconex.php";

class MiniLib {
    private $conn;

    public function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
    
    public function __construct() {
        $conex = new Conex();
        $this->conn = $conex->getConnection();
    }

    #
    # Left side part
    #
    # Profile (personal_info)
    # Languages
    # Own Projects
    # Social
    # Hobbies (maybe yes, or maybe not)
    #   

    public function func_personal_info() {
        $sql_personal_info = "SELECT * FROM personal_info";
        $result_personal_info = mysqli_query($this->conn, $sql_personal_info);

        if (!$result_personal_info) {
            die("Error en la consulta: " . mysqli_error($this->conn));
        }
        
        while($row = mysqli_fetch_assoc($result_personal_info)) {
            $profile_array = array("name" => $row["name"], "surname" => $row["surname"], "role" => $row["role"],
            "picture" => $row["picture"], "profile" => $row["profile"], "address" => $row["address"], "web" => $row["web"], 
            "email" => $row["email"], "phone" => $row["phone"]);
        }
        return $profile_array;
    }


    public function func_languages() {
        $sql_languages = "SELECT * FROM languages WHERE idpi = 1";   ## idpi is 1 because i have only 1 user. 
        $result_languages = mysqli_query($this->conn, $sql_languages);
        while($row = mysqli_fetch_assoc($result_languages)) {
            $language_array[] = array("lang" => $row["lang"], "level" => $row["level"]);
        }
        return $language_array;
    }


    public function func_ownProjects() {
        $sql_projects = "SELECT * FROM `projects` WHERE idpi = 1";
        $result_projects = mysqli_query($this->conn, $sql_projects);
        while($row = mysqli_fetch_assoc($result_projects)) {
            $projects_array[] = array("name" => $row["name"], "date" => $row["date"], "task" => $row["task"], "link" => $row["link"]);
        }
        return $projects_array;
    }


    public function func_social() {
        $sql_social = "SELECT social, name, link, icon FROM social WHERE idpi = 1";
        $result_social = mysqli_query($this->conn, $sql_social);
        while($row = mysqli_fetch_assoc($result_social)) {
            $social_array[] = array("social" => $row["social"], "name" => $row["name"], "link" => $row["link"], "icon" => $row["icon"]);
        }
        return $social_array;
    }

    
    public function func_hobbies() {
        $sql_hobbies = "SELECT hobbyName, hobbyImage, style FROM `hobbies` WHERE idpi = 1";
        $result_hobbies = mysqli_query($this->conn, $sql_hobbies);
        while($row = mysqli_fetch_assoc($result_hobbies)) {
            $profile_array[] = array("hobbyName" => $row["hobbyName"], "hobbyImage" => $row["hobbyImage"]);
        }
        return $profile_array;
    }

    #
    # content side part
    #
    # Work Experience
    # Skills & Expertise
    # EducationSELECT * FROM skills as s, expertise_type as et WHERE idet = s.type
    #

    public function func_work() {
        $sql_personal_info = "SELECT * 
        FROM `workExperience` 
        WHERE idpi = 1
        ORDER BY yearInit DESC";
        $result_personal_info = mysqli_query($this->conn, $sql_personal_info);
        while($row = mysqli_fetch_assoc($result_personal_info)) {
            $profile_array[] = array("yearInit" => $row["yearInit"], "yearEnd" => $row["yearEnd"], "task" => $row["task"],
            "company" => $row["company"], "description" => $row["description"]);
        }
        return $profile_array;
    }


    public function func_skills() {
        $sql_skills = "SELECT *
        FROM skills, expertise_type
        WHERE idet = exptypeid";
        $result_skills = mysqli_query($this->conn, $sql_skills);
        $skills_array = array();
        while($row = mysqli_fetch_assoc($result_skills)) {
            $type = $row['type'];
            $skill = array("skill" => $row["skill"], "exp" => $row["exp"]);
            if (!isset($skills_array[$type])) {
                $skills_array[$type] = array();
            }
            array_push($skills_array[$type], $skill);
        }
        return $skills_array;
    }


    public function func_education() {
        $sql_education = " SELECT year_init, year_end, university, carrer FROM `education` WHERE idpi = 1";
        $result_education = mysqli_query($this->conn, $sql_education);
        while($row = mysqli_fetch_assoc($result_education)) {
            $profile_array[] = array("year_init" => $row["year_init"], "year_end" => $row["year_end"], 
            "university" => $row["university"], "carrer" => $row["carrer"]);
        }
        return $profile_array;
    }    
}

$minilib = new MiniLib();


function yearsOfExperience($numYears) {
    for ($i = 0; $i <= $numYears; $i++) {
        echo "<i class='fa-solid fa-circle' style='color: #4b511f></i>";
    }
}
?>