<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class CheckAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkapi {merek}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $key = $this->argument('merek');
        $PDKI_URL = "https://pdki-indonesia-api.dgip.go.id/api/trademark/search?keyword=$key&page=1&type=trademark&order_state=asc";
    
        $client = new Client();
$response = $client->get($PDKI_URL);

// Get the response body as a string
$body = $response->getBody()->getContents();

$obj = json_decode($body);
$out = $obj->hits->hits;
$found = false;
$similarity = [];
foreach($out as $hit) {
$key2 = strtolower($hit->_source->nama_merek);
    if (strtolower($key) == $key2) {
    $found = true;
    $similarity[] = 100;
}
$max_length = max(strlen($key), strlen($key2));
$similarity[] = ((($max_length) - (levenshtein($key,$key2))) / $max_length) * 100;

}
// dd($out,$found);   
$output = (object)[];
$output->kata  = $key;
$output->tersedia = !$found;
$output->kesamaan = 0;
if (count($similarity) > 0) {
    $output->kesamaan = max($similarity) ;
}

dd(json_encode($output));
}
}
