<?php
echo password_hash("admin!", PASSWORD_DEFAULT);// displays hashed admin password
echo "<br>";

echo password_hash("Aliyah!", PASSWORD_DEFAULT); // displays hashed Aliyah password
echo "<br>";

echo password_hash("Hawra!", PASSWORD_DEFAULT); // displays hashed Hawra password
echo "<br>";

echo password_hash("Aroub!", PASSWORD_DEFAULT); // displays hashed Aroub password
echo "<br>";

echo password_hash("Joud!!", PASSWORD_DEFAULT); // displays hashed Joud password
echo "<br>";

echo password_hash("baduser!", PASSWORD_DEFAULT); // displays hashed bad user password
echo "<br>";

?>
