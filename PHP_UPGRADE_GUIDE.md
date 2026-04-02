# PHP Upgrade Guide - XAMPP Windows

## Current Status
- Current PHP: 8.0.30
- Target PHP: 8.2+ (for Laravel 12)
- Location: C:\xampp\php

## Step-by-Step Upgrade Instructions

### Step 1: Download PHP 8.2 (or 8.3)

1. Go to **https://windows.php.net/downloads/releases/**
2. Download the **Non Thread Safe (NTS)** version matching your system:
   - For 64-bit: `php-8.2.x-nts-Win32-x64-vs16.zip` 
   - For 32-bit: `php-8.2.x-nts-Win32-x86-vs16.zip`
   
   **Alternative:** Download PHP 8.3 (latest stable):
   - https://windows.php.net/download/releases/php-8.3.x-nts-Win32-x64-vs16.zip

### Step 2: Backup Current PHP

```powershell
Copy-Item -Path "C:\xampp\php" -Destination "C:\xampp\php_backup_8.0.30" -Recurse
```

This creates a backup in case something goes wrong.

### Step 3: Stop Apache Server

1. Open XAMPP Control Panel
2. Click "Stop" button for Apache
3. Wait for it to fully stop

### Step 4: Extract New PHP

1. Extract the downloaded PHP zip file to a temporary folder
2. Copy ALL files from the extracted folder
3. Paste into `C:\xampp\php` (replace all files when prompted)

### Step 5: Update php.ini (Important!)

Your old php.ini should still have your settings, but verify:

1. Open `C:\xampp\php\php.ini` in Notepad
2. Look for extensions you use (should be there from old config):
   - `extension=pdo_mysql`
   - `extension=openssl`
   - `extension=curl`
   - etc.

3. Make sure these match what you had before

### Step 6: Restart Apache

1. Open XAMPP Control Panel
2. Click "Start" button for Apache
3. Check if it starts without errors

### Step 7: Verify PHP Version

Run in PowerShell:
```powershell
C:\xampp\php\php.exe -v
```

Should show: **PHP 8.2.x** or **PHP 8.3.x**

---

## Automated Upgrade Scripts

### Option A: PowerShell Script (Recommended)

Create a file `upgrade-php.ps1` with this content:

```powershell
# Stop Apache
Write-Host "Stopping Apache..."
# Add command here if needed

# Backup current PHP
$backupPath = "C:\xampp\php_backup_$(Get-Date -Format 'yyyyMMdd_HHmmss')"
Write-Host "Backing up PHP to: $backupPath"
Copy-Item -Path "C:\xampp\php" -Destination $backupPath -Recurse

# Download PHP 8.2 NTS (Windows x64)
$phpUrl = "https://windows.php.net/downloads/releases/php-8.2.17-nts-Win32-x64-vs16.zip"
$zipPath = "C:\xampp\php-8.2-nts.zip"
$extractPath = "C:\xampp\php-extract"

Write-Host "Downloading PHP 8.2 NTS..."
Invoke-WebRequest -Uri $phpUrl -OutFile $zipPath

Write-Host "Extracting PHP..."
Expand-Archive -Path $zipPath -DestinationPath $extractPath

Write-Host "Copying files to C:\xampp\php..."
Copy-Item -Path "$extractPath\*" -Destination "C:\xampp\php" -Recurse -Force

Write-Host "Cleaning up..."
Remove-Item $zipPath
Remove-Item $extractPath -Recurse

Write-Host "Verifying installation..."
& "C:\xampp\php\php.exe" -v

Write-Host "Done! Restart Apache in XAMPP Control Panel."
```

Then run:
```powershell
Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process
.\upgrade-php.ps1
```

---

## Troubleshooting

### Apache won't start after upgrade
- **Solution:** Run `C:\xampp\apache\bin\httpd.exe -t` to check Apache config
- Check `C:\xampp\apache\logs\error.log` for specific errors

### PHP extensions missing
- **Solution:** Compare old and new `php.ini` files
- Uncomment/add missing extensions in new `php.ini`
- Restart Apache

### Permissions issues
- **Solution:** Right-click PowerShell → "Run as Administrator"
- Ensure Apache/MySQL are stopped before replacing files

### Version mismatch with Laravel
- After upgrade, run:
  ```powershell
  $env:PATH = "C:\xampp\php;$env:PATH"
  cd "C:\xampp\htdocs\OOP (TUK)Project\TUKAC-Technical-University-of-Kenya-Ability-Club-"
  composer install
  php artisan migrate:fresh
  ```

---

## Quick Verification Checklist

After upgrade, verify:

- [ ] `php -v` shows 8.2 or 8.3
- [ ] Apache starts without errors
- [ ] `php artisan --version` works
- [ ] Database is accessible

---

## Rollback Plan (If Something Goes Wrong)

If upgrade fails:

```powershell
# Stop Apache
# Delete C:\xampp\php
Copy-Item -Path "C:\xampp\php_backup_8.0.30" -Destination "C:\xampp\php" -Recurse
# Restart Apache
```

---

## Need More Help?

After PHP upgrade is done, run this command to verify Laravel works:

```powershell
$env:PATH = "C:\xampp\php;$env:PATH"
cd "C:\xampp\htdocs\OOP (TUK)Project\TUKAC-Technical-University-of-Kenya-Ability-Club-"
php artisan migrate:fresh
```

This will apply all your database migrations!

