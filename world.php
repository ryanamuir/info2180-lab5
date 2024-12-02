<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

// Establish a connection to the database
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Retrieve query parameters
$country = filter_input(INPUT_GET, "query", FILTER_SANITIZE_STRING);
$lookup = filter_input(INPUT_GET, "lookup", FILTER_SANITIZE_STRING);

// Query for countries if no 'lookup' is provided
if (!isset($lookup)) {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $stmt->execute(['country' => '%' . $country . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Query for cities if 'lookup=cities' is provided
if (isset($lookup) && $lookup === 'cities') {
    $stmt = $conn->prepare("
        SELECT cities.name, cities.district, cities.population
        FROM cities
        LEFT JOIN countries ON countries.code = cities.country_code
        WHERE countries.name LIKE :country
    ");
    $stmt->execute(['country' => '%' . $country . '%']);
    $city_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!-- Display country data if no 'lookup' parameter -->
<?php if (isset($country) && !isset($lookup)): ?>
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
          <?php if (count($results) > 0): ?>
              <?php foreach ($results as $row): ?>
                  <tr>
                      <td><?= htmlspecialchars($row['name']); ?></td>
                      <td><?= htmlspecialchars($row['continent']); ?></td>
                      <td><?= htmlspecialchars($row['independence_year']); ?></td>
                      <td><?= htmlspecialchars($row['head_of_state']); ?></td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr><td colspan="4">No countries found matching your search query.</td></tr>
          <?php endif; ?>
      </tbody>
  </table>
<?php endif; ?>

<!-- Display city data if 'lookup=cities' is provided -->
<?php if (isset($lookup) && $lookup === 'cities'): ?>
  <table>
      <thead>
          <tr>
              <th>Name</th>
              <th>District</th>
              <th>Population</th>
          </tr>
      </thead>
      <tbody>
          <?php if (count($city_results) > 0): ?>
              <?php foreach ($city_results as $row): ?>
                  <tr>
                      <td><?= htmlspecialchars($row['name']); ?></td>
                      <td><?= htmlspecialchars($row['district']); ?></td>
                      <td><?= htmlspecialchars($row['population']); ?></td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr><td colspan="3">No cities found for this country.</td></tr>
          <?php endif; ?>
      </tbody>
  </table>
<?php endif; ?>
