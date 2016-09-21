@echo off
:loop
for /f "skip=1 delims={}, " %%A in ('wmic nicconfig get ipaddress') do for /f "tokens=1" %%B in ("%%~A") do set "IP=%%~B"
	curl.exe -A"Mozilla/4.0" -b"__test=5dedd5fdc9f07c7e9cfa75934dda2b3a" "http://ericlin.nichesite.org/keyvalueDB.php?method=set&key=ailab-window-ip&value="%IP%
echo submiting ip.
ping 127.0.0.1 -n 10 >nul
goto loop
