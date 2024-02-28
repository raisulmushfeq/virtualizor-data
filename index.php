<?php
# PHP Script to get list of all VPS servers in Helios Server in Virtualizor.
require_once('admin.php');

$key =  '';
$pass = '';
$ip = '';

$admin = new Virtualizor_Admin_API($ip, $key, $pass);

$page = 0;
$reslen = 0;
//For Searching
$post = array();
$post['vpsid'] = '';
$post['vpsname'] = '';
$post['vpsip'] = '';
$post['vpshostname'] = '';
$post['vsstatus'] = '';
$post['vstype'] = '';
$post['speedcap'] = '';
$post['user'] = '';
$post['vsgid'] = '';
$post['vserid'] = '';
$post['plid'] = '';
$post['bpid'] = '';
$post['serid'] = ''; # Change Server IDs to get VPS list of different servers
$post['search'] = '';

$output = $admin->listvs($page ,$reslen ,$post);
# Check the raw output
// var_dump($output);



# Get the server name
if (!empty($output)) {
    $firstVpsDetails = reset($output);
    $serverName = $firstVpsDetails['server_name'];
    echo "<h2> VPS List for $serverName </h2> ";
}
# Convert server name to lowercase and remove space
$fomatted_server_name = str_replace(' ', '_', strtolower($serverName));

// Create a CSV file
$csvFileName = 'vps_data.csv';

$csvFileName = $fomatted_server_name . "_" .$csvFileName;
$csvFile = fopen($csvFileName, 'w');
// Write the header row
fputcsv($csvFile, ['VPS ID', 'Hostname', 'IP Address', 'Email Address']);

// Iterate through each VPS entry
foreach ($output as $vpsId => $vpsDetails) {
    $vpsidValue = $vpsDetails['vpsid'];
    $hostnameValue = $vpsDetails['hostname'];
    $emailAddress = $vpsDetails['email'];
    
    // Assuming each VPS can have multiple IPs, get the first IP only
    $ipAddress = reset($vpsDetails['ips']);
    echo "VPS ID: $vpsidValue, Hostname: $hostnameValue, IP Address: $ipAddress, Email Address: $emailAddress  <br>";
    fputcsv($csvFile, [$vpsidValue, $hostnameValue, $ipAddress, $emailAddress]);
}

?>

<a href="<?php gethostname(); echo "/$csvFileName"; ?>"> <button>Download As CSV</button> </a>
