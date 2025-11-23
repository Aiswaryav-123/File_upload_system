# File Upload System
## Project Description
A secure file upload system built with PHP and MySQL, which allows users to register, login, and upload files safely. The system validates file type, limits file size, sanitizes filenames, and logs all uploads for security monitoring.
## Features
- User registration and login using username and password.
- Secure file upload with:
    - Allowed file types: .jpg, .png, .pdf, .docx
    - Maximum file size: 5 MB
    - Unique file naming to prevent overwriting
- Logging of all file uploads : IP address, upload timestamp, file_status
