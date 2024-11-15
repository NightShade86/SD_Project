   Hello there, 
   this file will guide you on how to install and run our application.

1. Install XAMPP by using the link provided in Installer/Links for prerequisites.txt

2. Download and place cloudflared.exe file somewhere convienient 
[NOTE: IF YOU DOWNLOAD THE .EXE FILE, THE FILE WILL BE NAMED cloudflared-windows-386.exe
, PLEASE RENAME IT TO cloudflared.exe or cmd won't be able to run the file]

3. Download zip file from our Github repository and exctract it in xampp/htdocs/clinicdb/SD_Project/

   TEST:

i)   Run xampp and start Apache and MySQL.
ii)  paste [http://localhost/clinicdb/SD_Project/index_guess.php]
iii) if website loads, congratulations! our system is now running locally!

4. Run Command Prompt on your PC

5. Change directory to where cloudflared.exe is located. Example cd C:/cloudflared/ 

6. Run this code [cloudflared login] <-- this will open your browser automatically
   and show your a login screen for cloudflare. If you don't have an account please sign up and select your domain.
   Once you have logged in, it would download a certificate file for authorization called cert.perm
   in C:\Users\<your-username>\.cloudflared . Once you're done with this go back to Command Prompt.

7. Run [cloudflared tunnel create cms](cms is tunnel name you can change it to anything you want but you must remember it) ,
   after creating tunnel it would give a unique name for the tunnel that would look like this [adb00da5-5c4b-0912-be98-a754561b4a40].
   Store this id safely as we would be using this later.

8. On your cloudflare dashboard [https://dash.cloudflare.com/sign-up], select your website and go to DNS>Configuration tab.

9. Create 2 DNS record based on image in Installer/Cloudflare-DNS-Configuration.png 
   one should have your domain as name and the other should have www. Both of the targets should have something like this <tunnel-id-from-command-prompt>.cfargotunnel.com
   Save both DNS records. 

10.In your .cloudflared folder (ex:C:\Users\<your-username>\.cloudflared), create a config.yml file

YML FILE CONFIGURATION

-----------------------------------------------------------------------------------
tunnel: <tunnel-name  ex:cms>
credentials-file: C:\Users\<your-username>\.cloudflared\<json-file-name>.json

ingress:
  - hostname: <your domain here>
    service: http://localhost:<apache-port-in-xampp>
  - hostname: www.<your domain here>
    service: http://localhost:<apache-port-in-xampp>
  - service: http_status:404
-----------------------------------------------------------------------------------

11. If you have confirmed that you have set up everything perfectly, run this command on Command Prompt [cloudflare tunnel run cms] 
    -->(NOTE: if you changed the tunnel name earlier please replace cms with tunnel name)<--

12. If there's error, [https://one.dash.cloudflare.com/] go to this website, select your account, then Networks>Tunnels, look at your tunnel status,
    if it shows that it is healthy(tunnel is online) but your website is showing error 1003, it means your DNS records aren't correct.