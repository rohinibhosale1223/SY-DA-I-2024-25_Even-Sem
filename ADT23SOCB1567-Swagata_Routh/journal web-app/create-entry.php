<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'journal_db';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Entry
if (isset($_POST['add'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO journal_entries (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $stmt->close();
    }
}

// Update Entry
if (isset($_POST['update'])) {
    $id = $_POST['update_id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE journal_entries SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle edit request
$edit_entry = null;
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM journal_entries WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result_edit = $stmt->get_result();
    $edit_entry = $result_edit->fetch_assoc();
    $stmt->close();
}

// Delete Entry
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM journal_entries WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fetch Entries
$result = $conn->query("SELECT * FROM journal_entries ORDER BY created_at DESC");

// Get total count
$count_result = $conn->query("SELECT COUNT(*) as total FROM journal_entries");
$count_row = $count_result->fetch_assoc();
$total_entries = $count_row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Journal</title>
    <link rel="stylesheet" href="css/journal-entries.css">
</head>
<body>

<header>
    <div class="container">
        <h1>My Journal</h1>
        <nav>
             <nav>
      <a href="index.php">Home</a>
      <a href="..html/about.html">About</a>
      <a href="..html/contact-us.html">Contact Us</a>
      <a href="logout.php">Logout</a>
            <span class="entry-count">Total Entries: <strong><?= $total_entries ?></strong></span>
        </nav>
    </div>
</header>

<main>
    <?php if ($edit_entry): ?>
        <!-- Edit Entry Form -->
        <section class="form-section">
            <h2>Edit Entry</h2>
            <form method="POST" action="">
                <input type="hidden" name="update_id" value="<?= $edit_entry['id'] ?>">
                <input type="text" name="title" placeholder="Entry Title" required 
                    value="<?= htmlspecialchars($edit_entry['title']) ?>">
                <textarea name="content" placeholder="Write your thoughts..." required><?= htmlspecialchars($edit_entry['content']) ?></textarea>
                <button type="submit" name="update">Update Entry</button>
                <a href="?" class="cancel-edit">Cancel</a>
            </form>
        </section>
    <?php else: ?>
        <!-- New Entry Form -->
        <section class="form-section">
            <h2>New Entry</h2>
            <form method="POST" action="">
                <input type="text" name="title" placeholder="Entry Title" required>
                <textarea name="content" placeholder="Write your thoughts..." required></textarea>
                <button type="submit" name="add">Add Entry</button>
            </form>
        </section>
    <?php endif; ?>

    <!-- Entries Display -->
    <section class="entries-section">
        <h2>Past Entries</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="entry">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <small><?= $row['created_at'] ?></small>
                <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>

                <!-- Delete Form -->
                <form method="POST" action="" onsubmit="return confirm('Delete this entry?')" class="inline-form">
                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                    <button type="submit" name="delete" class="delete-button">Delete</button>
                </form>

                <!-- Edit Form Trigger -->
                <form method="POST" action="" class="inline-form">
                    <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="edit-button">Edit</button>
                </form>
            </div>
        <?php endwhile; ?>
    </section>
</main>

<footer>
    <p>&copy; <?= date("Y") ?> My Journal App</p>
</footer>

</body>
</html>
