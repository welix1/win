<?php
$firstName = '';
$lastName = '';
$email = '';

$errors = [
    'firstNameError' => '',
    'lastNameError' => '',
    'emailError' => ''
];

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstname'] ?? '';
    $lastName = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';

    if (empty($firstName)) {
        $errors['firstNameError'] = 'يرجى ادخال الاسم الاول';
    }
    
    if (empty($lastName)) {
        $errors['lastNameError'] = 'يرجى ادخال الاسم الثاني';
    }

    if (empty($email)) {
        $errors['emailError'] = 'يرجى ادخال البريد الإلكتروني';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['emailError'] = 'يرجى ادخال البريد الإلكتروني بشكل صحيح';
    }

    if (!array_filter($errors)) {
        $safe_firstName = mysqli_real_escape_string($conn, $firstName);
        $safe_lastName = mysqli_real_escape_string($conn, $lastName);
        $safe_email = mysqli_real_escape_string($conn, $email);

        $sql = "INSERT INTO users (firstname, lastname, email) VALUES ('$safe_firstName', '$safe_lastName', '$safe_email')";

        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo 'error :' . mysqli_error($conn);
        }
    }
}