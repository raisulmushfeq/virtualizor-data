# Simple PHP script to get list of VPS servers in a specific serverin Virtualizor using Virtualizor API

## Build and Run using
```
sudo docker build -t virtualizor . && sudo docker run -p 80:80 virtualizor
```

## Change the server ID
`post['serid'] =` from `index.php` needs to be updated with the proper server ID which can be found inside Servers > List Servers page in Virtualizor

## Add proper credentials
Credentials needs to be updated on `$key`, `$pass`, `$ip` with proper deails from Virtualizor > API Credentials