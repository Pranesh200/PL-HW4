<?php
class TriviaController {

    private $command;

    public function __construct($command) {
        $this->command = $command;
    }

    public function run() {
        switch($this->command) {
            case "question":
                $this->question();
                break;
            case "logout":
                $this->destroyCookies();
            case "login":
            default:
                $this->login();
                break;
        }
    }

    // Clear all the cookies that we've set
    private function destroyCookies() {          
        setcookie("correct", "", time() - 3600);
        setcookie("name", "", time() - 3600);
        setcookie("email", "", time() - 3600);
        setcookie("score", "", time() - 3600);
    }
    

    // Display the login page (and handle login logic)
    public function login() {
        if (isset($_POST["email"]) && !empty($_POST["email"])) { /// validate the email coming in
            setcookie("name", $_POST["name"], time() + 3600);
            setcookie("email", $_POST["email"], time() + 3600);
            setcookie("score", 0, time() + 3600);
            header("Location: ?command=question");
            return;
        }

        include "templates/login.php";
    }

    // Load a question from the API
    private function loadQuestion() {
        $triviaData = json_decode(
            file_get_contents("https://opentdb.com/api.php?amount=1&category=26&difficulty=easy&type=multiple")
            , true);
        // Return the question
        return $triviaData["results"][0];
    }

    public function getNewWord(){
        $response = file_get_contents("http://www.cs.virginia.edu/~jh2jf/courses/cs4640/spring2022/wordlist.txt");
        $array = explode("\n", $response);
        $word = $array[array_rand($array)];
        // $word = $array[0];
        setcookie("word", $word, time() + 3600);
        return $word;
    }

    // Display the question template (and handle question logic)
    public function question() {
        // set user information for the page from the cookie
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "score" => $_COOKIE["score"],
            "word" => $_COOKIE["word"]
         ];

         $word = $this->getNewWord();
         if ($word == null) {
             die("No questions available");
         }
 
        // load the question
        $question = $this->loadQuestion();
        if ($question == null) {
            die("No questions available");
        }


        // if the user submitted an answer, check it
        if (isset($_POST["answer"])) {
            $answer = $_POST["answer"];
            
           // $message = "<div class='alert alert-success'><b>$answer</b> was correct! You got it in $word guesses.</div>";
            if (strcasecmp($_COOKIE["answer"],$word) == 0) {
                // user answered correctly -- perhaps we should also be better about how we
                // verify their answers, perhaps use strtolower() to compare lower case only.
                $message = "<div class='alert alert-success'><b>$answer</b> was correct! You got it in $score guesses.</div>";

                // update the question information in cookies
                setcookie("answer", $question["correct_answer"], time() + 3600);
                $user["score"] += 100;
                
                 // Update the cookie: won't be available until next page load (stored on client)
                 setcookie("score", 0, time() + 3600);
               
            } else { 
                 // Update the score
                 $user["score"] += 1;
                  
                 // Update the cookie: won't be available until next page load (stored on client)
                 setcookie("score", $_COOKIE["score"] + 1, time() + 3600);
                $message = "<div class='alert alert-danger'><b>$answer</b> was incorrect! The answer was: {$_COOKIE["answer"]}</div>";
            }
            setcookie("correct", "", time() - 3600);
        }

        
        include("templates/question.php");
    }
}