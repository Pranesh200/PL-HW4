<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="your name">
        <meta name="description" content="include some description about your page">  
        <title>Trivia Game</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"> 
    </head>
    <body>
        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h1>CS4640 Extreme Wordle Game</h1>
                <h3>Hello <?=$user["name"]?>! Guesses: <?=$user["score"]?> <?=$user["word"]?></h3>
            </div>


            <table class="table" style="word-break: break-word">
            <thead>
            <tr>
                <th scope="col" class="text-center">Guessed Word</th>
                <th scope="col" class="text-center">Correct characters</th>
                <th scope="col" class="text-center">Correct position</th>
                <th scope="col" class="text-center">Guess length</th>
                </tr>
            </thead>
        <?php

            $guess = ($_POST["answer"]);
            $correctWord = str_split($user["word"]);

           
           
            if($guess){
                $correctCharacters = 0;
                $correctPostition = 0;
                $index = 0;
                $temp= str_split($guess);
                $lengthAns = strlen($user["word"]);
                $lenn = "correct";
                $guessLen = strlen($guess);

                foreach($temp as $c){
                    if( in_array($c, $correctWord)){
                        $correctCharacters += 1;
                        
                    }
                }

                for($a = 0; ($a < $guessLen && $a < $lengthAns); $a += 1){
                    if($temp[$a] == $correctWord[$a]){
                        $correctPostition += 1;
                    }
                }

                if($guessLen > $lengthAns){
                    $lenn = "too long";
                }elseif($guessLen < $lengthAns){
                    $lenn = "too short";
                }
            }


            
            if($guess){
                    echo '<tr>';
                    echo '<td>'. $guess .'</td>';
                    echo '<td>'. $correctCharacters .'</td>';
                    echo '<td>'. $correctPostition  .'</td>';
                    echo '<td>'. $lenn  .'</td>';
                    echo '</tr>';
                }
        ?>
    </table>
            <div class="row">
                <div class="col-xs-8 mx-auto">
                <form action="?command=question" method="post">
                    <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Guess the word:</h2>
                    <input type="hidden" name="questionid" value="<?=$question["id"]?>"/>
                    </div>
                    <!-- <?=$message?> -->
                    <div class="h-10 p-5 mb-3">
                        <input type="text" class="form-control" id="answer" name="answer" placeholder="Type your answer here">
                    </div>
                    <div class="text-center">                
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="?command=logout" class="btn btn-danger">End Game</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>


<!-- <table class="table" style="word-break: break-word">
    <thead>
        <tr><th scope="col" class="text-center">Guess</th>
        <th scope="col" class="text-center">Correct characters</th>
        <th scope="col" class="text-center">Characters in correct position</th>
        <th scope="col" class="text-center">Guess length</th>
    </tr></thead>
    <tbody><tr><td>a</td><td class="text-center">1</td><td class="text-center">0</td><td class="text-center">too short</td></tr></tbody></table> -->