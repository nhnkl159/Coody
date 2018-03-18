<?php
class ES_2
{
    function __construct()
    {
    }

    /**
     * Simple function to check if url needs a authentication if true return headers.
     *
     * @param $url
     *
     * @return headers|false
     */
    public function AuthRequest($url)
    {
        //Initiate a new cURL session.
        $curl = curl_init();
        //Create array for our options.
        $options = [CURLOPT_RETURNTRANSFER => true, // Sets the option to return transfer as string.
        CURLOPT_BINARYTRANSFER => true, // Sets the option to return the raw output because we are using CURLOPT_RETURNTRANSFER.
        CURLOPT_NOBODY => true, //We dont need the body, loading will be faster.
        CURLOPT_HEADER => true, //Lets enable headers.
        CURLOPT_URL => $url
        // Our URL
        ];
        //Lets set our options to the curl session.
        curl_setopt_array($curl, $options);
        //Execute our cURL sesssion.
        $response = curl_exec($curl);
        //Lets get our httpcode !
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        //Check if the url needs a auth.
        if ($httpcode == 401)
        {
            //Return all headers.
            return curl_getinfo($curl);
        }

        //We have to close the session to avoid wasting resources.
        curl_close($curl);

        //Return response if the url dont need auth.
        return $response;
    }

    /**
     * Simple function to get URL HTML source.
     *
     * @param $url
     *
     * @return pagehtml
     */
    public function GetHTML($url)
    {
        //Initiate a new cURL session.
        $curl = curl_init();
        //Create array for our options.
        $options = [CURLOPT_RETURNTRANSFER => true, // Sets the option to return transfer as string.
        CURLOPT_BINARYTRANSFER => true, // Sets the option to return the raw output because we are using CURLOPT_RETURNTRANSFER.
        CURLOPT_URL => $url
        // Our URL
        ];
        //Lets set our options to the curl session.
        curl_setopt_array($curl, $options);
        //Lets get our content !
        $htmlcontent = curl_exec($curl);
        //We have to close the session to avoid wasting resources.
        curl_close($curl);

        //Return the HTML content
        return $htmlcontent;
    }

    /**
     * Simple function to get specific data from HTML file.
     *
     * @param $file
     *
     * @return data
     */
    public function ParseHTML($file)
    {
        //Lets check first if the file exist.
        if (!file_exists($file))
        {
            return; //Nope our file doesnt exist.
            
        }
        //Lets get our file content.
        $content = file_get_contents($file, true);

        //Explode the $content var and get our data.
        $first = explode('<td class="MMR">', $content);
        $second = explode('</td>', $first[1]);

        //Return the specfic data we looking for.
        return $second[0];
    }

    /**
     * Simple function to get array as arg and compile into a file as json.
     *
     * @param $arg
     *
     * @return data
     */
    public function DataJson($arg)
    {
        //Lets check if our $arg is a array, if false return;
        if (!is_array($arg))
        {
            return; //Nope our arg isnt array.
            
        }

        //Encode our array into a json.
        $content = json_encode($arg);

        //Put our json into a file.
        if (file_put_contents('example.json', $content))
        {
            return true;
        }

        return false;
    }
}

$ourclass = new ES_2();

echo 'GetHTML : </br> ' . $ourclass->GetHTML('http://eune.op.gg/summoner/ajax/mmr/userName=Wait%20For%20Late') . '</br>';
echo 'ParseHTML : </br> ' . $ourclass->ParseHTML('Simple.html') . '</br>';
echo 'DataJson : </br> ' . $ourclass->DataJson(array(
    "Example1",
    "Example2",
    "Example3"
)) . '</br> AuthRequest : </br>';
echo print_r($ourclass->AuthRequest('http://www.pagetutor.com/keeper/mystash/secretstuff.html'));

