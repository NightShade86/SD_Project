# SD_Project - Clinic Management System

Welcome to the **SD Project** repository, developed by **Group 1**.  
Our mission is to enhance the clinic management system at **Dr. Thong's Clinic**, where patient data and clinical visits are still recorded manually using paper and book logs. This project aims to modernize their system with a digital solution.

---

## 🚀 Project Setup Guide

### Step 1: Install Prerequisites
1. **Install XAMPP:**
   Download and install XAMPP from the provided link in the **Installer/Links for prerequisites.txt**.

2. **Download and Configure `cloudflared.exe`:**
   - Download `cloudflared.exe` and place it in a convenient location on your PC.
   - **Important:** If you download the file and it’s named `cloudflared-windows-386.exe`, rename it to **`cloudflared.exe`** so that the command line can run it.

### Step 2: Set Up the Application

1. **Download and Extract Project Files:**
   - Download the zip file from our [GitHub repository](#) and extract it to `xampp/htdocs/clinicdb/SD_Project/`.

2. **Start XAMPP:**
   - Run **XAMPP** and start both **Apache** and **MySQL**.

3. **Test Local Setup:**
   - Open your browser and go to `http://localhost/clinicdb/SD_Project/index_guess.php`.
   - If the website loads, congratulations! Your system is now running locally.

### Step 3: Cloudflare Configuration

1. **Open Command Prompt:**
   - Run **Command Prompt** on your PC.

2. **Navigate to `cloudflared.exe`:**
   - Change the directory to where `cloudflared.exe` is located. Example:
     ```bash
     cd C:/cloudflared/
     ```

3. **Login to Cloudflare:**
   - Run the command:
     ```bash
     cloudflared login
     ```
     This will open your browser with a login screen for Cloudflare. 
   - If you don’t have an account, sign up and select your domain.
   - After logging in, a certificate file (`cert.pem`) will be downloaded to `C:\Users\<your-username>\.cloudflared`.

4. **Create a Tunnel:**
   - Run the following command to create a tunnel:
     ```bash
     cloudflared tunnel create cms
     ```
     You can replace `cms` with any tunnel name, but remember this name for later.
   - After creation, a unique tunnel ID will be provided, such as `adb00da5-5c4b-0912-be98-a754561b4a40`. **Store this ID safely**.

### Step 4: Cloudflare DNS Setup

1. **Go to Cloudflare Dashboard:**
   - Visit [Cloudflare Dashboard](https://dash.cloudflare.com/sign-up) and log in to your account.
   - Select your website, then navigate to the **DNS** tab.

2. **Create DNS Records:**
   - Create two DNS records:
     - One for the domain (e.g., `yourdomain.com`).
     - One for the `www` subdomain (e.g., `www.yourdomain.com`).
   - Both records should point to the following destination:
     ```
     <tunnel-id-from-command-prompt>.cfargotunnel.com
     ```
   - Save both DNS records.

### Step 5: Cloudflare Tunnel Configuration

1. **Create `config.yml` File:**
   - In your `.cloudflared` folder (e.g., `C:\Users\<your-username>\.cloudflared`), create a new file named **`config.yml`** with the following content:
     ```yaml
     tunnel: <tunnel-name>  # Replace with the tunnel name, e.g., cms
     credentials-file: C:\Users\<your-username>\.cloudflared\<json-file-name>.json

     ingress:
       - hostname: <your-domain>
         service: http://localhost:<apache-port-in-xampp>
       - hostname: www.<your-domain>
         service: http://localhost:<apache-port-in-xampp>
       - service: http_status:404
     ```

2. **Run Cloudflare Tunnel:**
   - If everything is configured correctly, run the following command to start the tunnel:
     ```bash
     cloudflared tunnel run cms
     ```
     - Replace `cms` with the name of your tunnel if you changed it.

### Step 6: Troubleshooting

1. **Cloudflare Tunnel Status:**
   - If the tunnel is running but your website shows an error (e.g., **Error 1003**), check your DNS records in the Cloudflare dashboard.
   - Go to [Cloudflare Network Tunnels](https://one.dash.cloudflare.com/) and ensure that your tunnel is marked as "healthy" and online.

---

## 📞 Support

For any issues or support requests, feel free to open an issue in our GitHub repository or contact the team via email.

---

Thank you for using the **SD Project**! We hope it helps streamline the clinic’s operations.
