# Password Manager CLI

A secure, lightweight command-line interface (CLI) application built in PHP for managing passwords. It uses a master password to encrypt and store credentials locally in a JSON file, offering a simple, offline solution with no external dependencies.

## Features
- **Master Password Protection**: Set a master password to secure all entries.
- **Add Password**: Store passwords with optional usernames for any service (e.g., Gmail).
- **View Password**: Display username and timestamp, with the decrypted password copied to the clipboard.
- **Update Password**: Modify an existing password while preserving other details.
- **Delete Password**: Remove entries by service name.
- **Security**: Passwords are encrypted with AES-256-CBC using a master password-derived key and unique IV per entry.
- **Cross-Platform**: Compatible with Windows, macOS, and Linux.

## Requirements
- **PHP**: Version 7.4 or higher with the OpenSSL extension enabled.
- **Operating System**: Windows, macOS, or Linux.
- **Optional (Linux)**: `xclip` for clipboard support (`sudo apt install xclip` on Debian/Ubuntu).

## Installation
1. **Clone or Download**:
   - Clone the repository:
     ```bash
     git clone https://github.com/yourusername/password-manager-cli.git
     ```
   - Or download and extract the ZIP file.
2. **Navigate to Directory**:
   ```bash
   cd password-manager-cli
   ```
3. **Set Permissions** (Linux/macOS):
   ```bash
   chmod 700 storage
   chmod +x main.php
   ```
4. **Verify PHP Installation**:
   - Check: `php -v`
   - Install if needed (e.g., `sudo apt install php` on Ubuntu).

## Usage
Run the application using the single entry point:
```bash
php main.php
```
- On first run, you’ll be prompted to set a master password.
- Use the interactive menu to manage passwords.

### Menu Options
1. **Add a new password**: Enter a service name, optional username, and password.
2. **View a password**: Retrieve details for a service and copy the password to the clipboard.
3. **Update a password**: Update the password for an existing service.
4. **Delete a password**: Remove an entry by service name.
5. **Exit**: Quit the application.

## File Structure
```
password-manager-cli/
├── storage/
│   ├── master.hash    # Hashed master password
│   └── passwords.json # Encrypted password entries
├── src/
│   ├── addPassword.php    # Logic for adding passwords
│   ├── viewPassword.php   # Logic for viewing passwords
│   ├── updatePassword.php # Logic for updating passwords
│   └── deletePassword.php # Logic for deleting passwords
├── lib/
│   ├── config.php    # Encryption configuration
│   └── function.php  # Core utility functions
├── main.php          # Single entry point with menu
└── README.md         # This documentation
```

## Security Notes
- **Encryption**: Uses AES-256-CBC with a key derived from the master password and a unique initialization vector (IV) per entry.
- **Local Storage**: Passwords are stored in `storage/passwords.json`. Back up this file to prevent data loss.
- **Master Password**: If lost, passwords cannot be recovered—store it securely.
- **File Permissions**: Restrict access to the `storage/` directory (e.g., `chmod 700 storage`).

## Example `passwords.json`
```json
[
    {
        "id": "entry_67f2545a74c6a7.92668048",
        "title": "gmail",
        "username": "username@gmail.com",
        "password": "*********"
    }
]
```

## Troubleshooting
- **Clipboard Not Working**:
  - Linux: Install `xclip` (`sudo apt install xclip`).
  - macOS: Ensure `pbcopy` is functional.
- **Permission Denied**: Check `storage/` permissions (`ls -ld storage` or `dir storage` on Windows).
- **PHP Errors**: Confirm OpenSSL is enabled (`php -m | grep openssl`).

## Development
- **Structure**: `main.php` serves as the entry point, delegating to scripts in `src/` using functions from `lib/function.php`.
- **Customization**: Modify functionality/feature in `src/` or add new features by extending the menu in `main.php`.

## Contributing
Contributions are welcome! To contribute:
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit changes (`git commit -m "Add feature"`).
4. Push to the branch (`git push origin feature-name`).
5. Open a pull request.

Report bugs or suggest features via the [Issues](https://github.com/farhanT23/password-manager-cli/issues) page.


## Acknowledgments
- Built with PHP and OpenSSL for secure password management.
- Designed for simplicity and offline use.