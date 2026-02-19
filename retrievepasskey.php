<?php
// Handle form submission
$result = '';
$resultClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $passkeyId = strtoupper(trim($_POST['passkeyId'] ?? ''));

    // Load subscriber data from JSON
    //$subscribersFile = __DIR__ . '/subscribers.json';
    $subscribersFile = 'subscribers.json';
    $subscribers = json_decode(file_get_contents($subscribersFile), true);

    if ($subscribers) {
        $user = null;
        foreach ($subscribers as $sub) {
            if ($sub['phone'] === $phone && strtolower($sub['email']) === strtolower($email) && $sub['passkeyId'] === $passkeyId) {
                $user = $sub;
                break;
            }
        }

        if ($user) {
            $result = "✅ This is your passkey: <strong>{$user['passkey']}</strong>";
            $resultClass = "success";
        } else {
            $result = "❌ Invalid details. Please check and try again.";
            $resultClass = "error";
        }
    } else {
        $result = "❌ Subscriber data not found.";
        $resultClass = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Passkey Validation</title>
<link rel="manifest" href="/manifest.json">
<style>
body {
  font-family: 'Poppins', sans-serif;
  background: hsl(120, 21%, 93%);
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}
.container {
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  width: 350px;
  text-align: center;
  display:flex;
  flex-wrap:wrap;
}
h2 { color: #333; margin-bottom: 20px; }
input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; }
button { background: #007bff; color: white; padding: 10px 0; border: none; width: 100%; border-radius: 8px; font-size: 16px; cursor: pointer; transition: 0.3s; }
button:hover { background: #0056b3; }
#result { margin-top: 15px; font-weight: bold; }
.success { color: green; }
.error { color: red; }
</style>
</head>
<body>
<div class="container">
  <h2>Retrieve Your Passkey</h2>
  <p>Your passkey should look like this : NSQAPXXXXXXXXXX</p>
  <ol>
    <li>Enter the phone and Email that you used when you purchased your passkey</li><br>
    <li>Enter your unique passkey ID e.g NSQAP111</li><br>
    <li>Lastly click Validate to retrieve your passkey</li>
  </ol><br>

  <form method="post">
    <input type="text" name="phone" placeholder="Enter Phone Number" required>
    <input type="email" name="email" placeholder="Enter Email" required>
    <input type="text" name="passkeyId" placeholder="Enter Passkey ID (e.g. NSQAP11)" required>
    <button type="submit">Validate</button>
  </form>

  <p id="result" class="<?php echo $resultClass; ?>">
    <?php echo $result; ?>
  </p><br><br>
  <a href="index.html">Goto Activation Page</a>
</div>
</body>
</html>