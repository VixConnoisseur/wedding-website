Jennifer & Arvin - Wedding Website (Tailwind) - UPDATED

What's new:
- New decorative floral borders (left/right/top/bottom) - images in /images/*.png
- Script font added for names (Great Vibes). Header uses images/hero-new.png as hero background.

How to swap the HERO image:
1. Prepare a high-resolution JPG/PNG image (recommended size: 2000x1200px). A floral border or full-bleed photo works best.
2. Rename your image to 'hero-new.png' and place it into the 'images/' folder, replacing the existing hero-new.png.
   OR edit index.php and change the URL in the header inline style to match your filename.
3. Refresh the site in the browser. If you want a different format, update the path in index.php.

How to replace floral borders and fonts:
- Replace images/floral-left.png, floral-right.png, floral-top.png, floral-bottom.png with your own floral PNGs (transparent backgrounds recommended).
- Fonts: the site uses Google Fonts (Playfair Display & Great Vibes). To change, edit the <link> in index.php to include other Google Fonts.

Run db_setup.php (one-click) - step-by-step:
1. Start XAMPP Control Panel and ensure Apache and MySQL are running.
2. Copy the folder 'wedding-website-jennifer-arvin' into XAMPP's htdocs directory (e.g., C:\xampp\htdocs\).
3. In your browser visit:
   http://localhost/wedding-website-jennifer-arvin/db_setup.php
   - You should see messages: "Default admin created..." and "Setup complete." If it says "Default admin already exists," that's fine.
4. After confirming, DELETE the db_setup.php file from the folder for security (very important!).
5. Open phpMyAdmin (http://localhost/phpmyadmin) and verify the database 'wedding_db' exists and tables 'admins' and 'responses' are present.
6. Login as admin: http://localhost/wedding-website-jennifer-arvin/login.php
   Default credentials: admin@wedding.com / password123
7. Change the admin password using the Register page or by updating directly in the DB.

If you prefer manual SQL import:
- Use phpMyAdmin -> Import -> choose 'wedding_db.sql' and run it.

Troubleshooting:
- If you get "Unknown database 'wedding_db'", run db_setup.php or import the SQL.
- If you cannot write images, check file permissions.

Enjoy — replace images with your own floral artwork to get the full final look.
