const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(bodyParser.json());

// MySQL Connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',      // use your MySQL password
  database: 'laptop_hub'
});

db.connect(err => {
  if (err) throw err;
  console.log('✅ Connected to MySQL Database');
});

// Register User
app.post('/register', (req, res) => {
  const { username, email, password } = req.body;
  const sql = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
  db.query(sql, [username, email, password], (err, result) => {
    if (err) return res.status(500).send(err);
    res.send({ message: 'User registered successfully' });
  });
});

// Login User
app.post('/login', (req, res) => {
  const { email, password } = req.body;
  const sql = 'SELECT * FROM users WHERE email = ? AND password = ?';
  db.query(sql, [email, password], (err, results) => {
    if (err) return res.status(500).send(err);
    if (results.length > 0) {
      res.send({ message: 'Login successful', user: results[0] });
    } else {
      res.status(401).send({ message: 'Invalid credentials' });
    }
  });
});

// Get Products
app.get('/products', (req, res) => {
  db.query('SELECT * FROM products', (err, results) => {
    if (err) return res.status(500).send(err);
    res.send(results);
  });
});

app.listen(3000, () => {
  console.log('🚀 Server running on http://localhost:3000');
});
