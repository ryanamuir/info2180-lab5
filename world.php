<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$country = filter_input(INPUT_GET,"query", FILTER_SANITIZE_STRING);
$data = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
$results = $data->fetchAll(PDO::FETCH_ASSOC);

if (count($results) > 0):
  ?>
  
  <table>
      <thead>
          <tr>
              <th>Country Name</th>
              <th>Continent</th>
              <th>Independence Year</th>
              <th>Head of State</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach ($results as $row): ?>
          <tr>
              <td><?= htmlspecialchars($row['name']); ?></td>
              <td><?= htmlspecialchars($row['continent']); ?></td>
              <td><?= htmlspecialchars($row['independence_year']); ?></td>
              <td><?= htmlspecialchars($row['head_of_state']); ?></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
  </table>
  
  <?php else: ?>
      <p>No countries found matching your search query.</p>
  <?php endif; ?>
