<?php
session_start();

// Check if the session is expired
if (!isset($_SESSION['loginTime']) || (time() - $_SESSION['loginTime'] > 259200)) { // 259200 seconds = 3 days
    session_unset();
    session_destroy();
    header("Location: ../PHP/login.php");
    exit;
}

// Check if the user is logged in and has the correct user type
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: ../PHP/login.php");
    exit;
}

// Check user type for accessing Super Admin pages
if (basename($_SERVER['PHP_SELF']) === 'super_admin.php' && !in_array($_SESSION['userType'], ['Super Admin', 'Owner'])) {
    header("Location: ../PHP/login.php");
    exit;
}

// Reset login time on each valid request to keep session active
$_SESSION['loginTime'] = time();

// User is logged in, set user details
$userLoggedIn = true;
$userName = $_SESSION['userName'];
$userType = $_SESSION['userType'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DO Registration Panel</title>

    <link rel="apple-touch-icon" sizes="180x180" href="../Images/Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Images/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Images/Favicon/favicon-16x16.png">
    <link rel="manifest" href="../Images/Favicon/site.webmanifest">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="stylesheet" href="../CSS/boostrap.css">
    <link rel="stylesheet" href="../CSS/Template/header.css">
    <link rel="stylesheet" href="../CSS/Body/data_officer_form_admin_panel.css">
    <link rel="stylesheet" href="../CSS/Template/footer.css">

    <script defer src="../JS/header.js"></script>
    <script src="../JS/jquery-3.7.1.min.js"></script>
    <script defer src="../JS/data_officer_form_admin_panel.js"></script>
</head>

<body>

    <!-- Header Section -->
    <header class="DF PR">

        <!-- Mobile Navigation Icon-->
        <div class="mobile-nav-container open">
            <i class="fa-solid fa-2x fa-bars"></i>
        </div>

        <div class="mobile-nav-container close hidden">
            <i class="fa-solid fa-2x fa-xmark"></i>
        </div>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav hidden-effect">
            <ul>
                <?php if ($userLoggedIn) : ?>
                    <li class="mobile_login_container">
                        <div class="user_info_container">
                            <img src="../Images/Header/profile.png" alt="User Image" class="user_image">
                            <div class="user_info">
                                <span class="user_name"><?php echo htmlspecialchars("Hello " . $userName); ?></span>
                                <span class="user_type"><?php echo htmlspecialchars($userType); ?></span>
                            </div>
                            <form class="DF PR" action="../PHP/logout.php" method="post">
                                <button type="submit" class="logout_btn">Log Out</button>
                            </form>
                        </div>
                    </li>
                <?php endif; ?>

                <li><a href="../index.html">
                        <div><i class="fa-solid fa-house"></i></div>
                        <h3>Home</h3>
                    </a>
                </li>

                <li><a href="../Pages/Contributors.html">
                        <div><i class="fa-solid fa-handshake-angle"></i></div>
                        <h3>Contributors</h3>
                    </a>
                </li>

                <li><a href="../Pages/Gallery.html">
                        <div><i class="fa-regular fa-images"></i></div>
                        <h3>Gallery</h3>
                    </a>
                </li>

                <li><a href="#contact">
                        <div><i class="fa-regular fa-address-book"></i></div>
                        <h3>Contact</h3>
                    </a>
                </li>
            </ul>
        </nav>



        <!-- Mobile Navigation Logo -->
        <div class="mobile-gov-logo-container mbglc1">
            <img src="../Images/Header/MOE logo Light mode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Mobile Navigation Logo -->
        <div class="mobile-gov-logo-container mbglc2 hidden">
            <img src="../Images/Header/MOE logo Darkmode.png" alt="Mobile_Gov_Logo">
        </div>

        <!-- Header Logo Container  -->
        <div class=" gov-logo-container DG PR center">

            <!-- Header Logo Grid Left -->
            <div class="gov-logo DF">
                <img loading="lazy" draggable="false" src="../Images/Header/gov_logo.png" alt="GOV_LOGO">
            </div>

            <!-- Header Logo Grid Right -->
            <div class="gov-logo-title">
                <h1>අධ්‍යාපන අමාත්‍යාංශය</h1>
                <h1>கல்வி அமைச்சு</h1>
                <h1>Ministry of Education</h1>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="wide_navigation">
            <ul class="DF PR center">
                <li>
                    <a class="DF FD-R center" href="../index.html">
                        <div>
                            <i class="fa-solid fa-house"></i>
                        </div>
                        <h3>Home</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="../Pages/Contributors.html">
                        <div>
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h3>Contributors</h3>
                    </a>
                </li>
                <li><a class="DF FD-R center" href="../Pages/Gallery.html">
                        <div>
                            <i class="fa-regular fa-images"></i>
                        </div>
                        <h3>Gallery</h3>
                    </a>
                </li>
            </ul>
        </nav>


        <!-- Wide Login Container -->
        <div class="wide_login_container <?php echo $userLoggedIn ? '' : 'hidden'; ?>">
            <div class="user_icon_container">
                <i class="fa-solid fa-user"></i>
                <span class="greeting_text">Hello, <br><em><?php echo htmlspecialchars($userName); ?></em></span>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <?php if ($userLoggedIn) : ?>
                <div class="dropdown">
                    <div class="user_info_container">
                        <img src="../Images/Header/profile.png" alt="User Image" class="user_image">
                        <div class="user_info">
                            <span class="user_name"><?php echo htmlspecialchars($userName); ?></span>
                            <span class="user_type"><?php echo htmlspecialchars($userType); ?></span>
                        </div>
                    </div>
                    <form action="../PHP/logout.php" method="post">
                        <button type="submit" class="logout_btn">Log Out</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>



        <!-- Data Officer Logo -->
        <div class="data-officer-logo-container DF PR dolc1">
            <img loading="lazy" class="PR" src="../Images/Header/Data_Officer Logo White.png" alt="Data_officer_Logo">
        </div>

        <div class="data-officer-logo-container DF PR dolc2 hidden">
            <img loading="lazy" class="PR" src="../Images/Header/Data_Officer Logo Dark.png" alt="Data_officer_Logo">
        </div>

        <!-- Dark Mode  -->
        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <div class="slider round"></div>
            </label>
            <em class="mode1">Enable Dark Mode</em>
            <em class="mode2 hidden">Disable Dark Mode</em>
        </div>

    </header>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Workplace Details Admin Panel</h1>
        <div class="card mb-4">
            <div class="card-body">
                <div class="filter-container">
                    <div class="row g-3">
                        <!-- Grouping related filters -->
                        <div class="col-md-4">
                            <input type="text" id="name" class="form-control" placeholder="Full Name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="nic" class="form-control" placeholder="NIC">
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="date" id="submittedAt_start" class="form-control">
                                <span class="input-group-text">to</span>
                                <input type="date" id="submittedAt_end" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="currentWorkingPlace" class="form-control" placeholder="Work Category">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="selectedInstituteCode" class="form-control" placeholder="Institute Code">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="selectedInstituteName" class="form-control" placeholder="Institute Name">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="province" class="form-control" placeholder="Province">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="district" class="form-control" placeholder="District">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="zone" class="form-control" placeholder="Zone">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="division" class="form-control" placeholder="Division">
                        </div>
                        <div class="col-md-4">
                            <button id="filterBtn" class="btn btn-primary w-100" data-bs-toggle="tooltip" title="Apply Filters">Filter</button>
                        </div>
                        <div class="col-md-4">
                            <button id="exportBtn" class="btn btn-secondary w-100" data-bs-toggle="tooltip" title="Export as CSV">Export CSV</button>
                        </div>
                        <div class="col-md-4">
                            <select id="tableSelect" class="form-select">
                                <option value="current">Workplace Details</option>
                                <option value="history">Workplace Details History</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="id" checked>
                            ID</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="fullName" checked>
                            Full Name</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="nameWithInitials" checked> Name With Initials</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="nic" checked>
                            NIC</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="email" checked>
                            Email</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="whatsappNumber" checked> WhatsApp No</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="mobileNumber" checked> Mobile No</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="headOfInstituteName" checked> Institute Head</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="headOfInstituteContactNo" checked> Head Contact</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="currentWorkingPlace" checked> Work Category</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="selectedInstituteCode" checked> Institute Code</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="selectedInstituteName" checked> Institute Name</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="Province" checked>
                            Province</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="District" checked>
                            District</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="Zone" checked>
                            Zone</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="Division" checked>
                            Division</label>
                    </div>
                    <div class="col-md-2">
                        <label><input type="checkbox" class="form-check-input columnToggle" value="submittedAt" checked>
                            Submitted At</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="sortable" data-column="id" data-order="asc">ID<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="fullName" data-order="asc">Full Name<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="nameWithInitials" data-order="asc">Name With Initials<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="nic" data-order="asc">NIC<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="email" data-order="asc">Email<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="whatsappNumber" data-order="asc">WhatsApp No<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="mobileNumber" data-order="asc">Mobile No<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="headOfInstituteName" data-order="asc">Institute Head<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="headOfInstituteContactNo" data-order="asc">Head Contact<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="currentWorkingPlace" data-order="asc">Work Category<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="selectedInstituteCode" data-order="asc">Institute Code<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="selectedInstituteName" data-order="asc">Institute Name<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="Province" data-order="asc">Province<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="District" data-order="asc">District<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="Zone" data-order="asc">Zone<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="Division" data-order="asc">Division<i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-column="submittedAt" data-order="asc">Submitted At<i class="fas fa-sort sort-icon"></i></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <!-- Table body content will be dynamically generated -->
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button id="firstPage" class="btn btn-primary">First</button>
            <button id="prevPage" class="btn btn-primary">Previous</button>
            <span id="currentPage">1</span>
            <button id="nextPage" class="btn btn-primary">Next</button>
            <button id="lastPage" class="btn btn-primary">Last</button>
        </div>
    </div>

    <!-- Footer Starts Here -->
    <footer class="footer DF FD-C PR">
        <!-- Contact Section -->
        <section class="contact DG PR">
            <!-- Google Map Column -->
            <div class="location DF FD-C PR center">
                <h3>Google Map</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3960.9941086631047!2d79.930527!3d6.891307!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2517dc82a9fef%3A0xa2cb100ac511407c!2sMinistry%20of%20Education!5e0!3m2!1sen!2sus!4v1712734841372!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div id="contact" class="contact_details DF FD-C PR">
                <h3>Contact Details</h3>
                <div>
                    <div class="address DF FD-R PR center">
                        <i class="fa-solid fa-1x fa-location-dot"></i>
                        <p>
                            Data Management Branch,<br>
                            3rd Floor,<br>
                            Ministry of Education,<br>
                            Isurupaya,<br>
                            Battaramulla,<br>
                            SriLanka.
                        </p>
                    </div>

                    <div class="phone DF FD-R PR">
                        <i class="fa-solid fa-1x fa-phone"></i>
                        <p>+94 11-2784837</p>
                    </div>

                    <div class="phone DF FD-R PR">
                        <i class="fa-solid fa-1x fa-phone"></i>
                        <p>+94 11-2075854</p>
                    </div>

                    <div class="email DF FD-R PR">
                        <i class="fa-solid fa-envelope"></i>
                        <p>dataofficermoe@gmail.com</p>
                    </div>
                </div>
            </div>

            <div class="links DF FD-C PR center">
                <h3>Related Links</h3>
                <ul class="DF FD-C PR ">
                    <li><a target="_blank" href="https://moe.gov.lk/">Ministry of Education</a></li>
                    <li><a target="_blank" href="https://www.doenets.lk/">Department of Examinations</a></li>
                    <li><a target="_blank" href="http://www.edupub.gov.lk/">Education Publication Department</a></li>
                    <li><a target="_blank" href="http://www.statistics.gov.lk/">Department of Census and Statics</a>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Horizontal Line -->
        <div class="horizontal-line-footer"></div>
        <!-- Section Copyright -->

        <section class="copyright">
            <p>Copyright © 2024 Data Management Branch,
                Ministry of Education.</p>
        </section>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableHeaders = document.querySelectorAll('.sortable');

            tableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const column = this.dataset.column;
                    const currentOrder = this.dataset.order;
                    const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';

                    fetchData(1, column, newOrder);

                    // Reset all headers
                    tableHeaders.forEach(h => {
                        h.classList.remove('asc', 'desc');
                        h.querySelector('.sort-icon').classList.remove('fa-sort-up', 'fa-sort-down');
                        h.querySelector('.sort-icon').classList.add('fa-sort');
                        h.dataset.order = 'asc'; // Reset to initial order
                    });

                    // Set the current header
                    this.dataset.order = newOrder;
                    this.classList.add(newOrder);
                    this.querySelector('.sort-icon').classList.remove('fa-sort');
                    this.querySelector('.sort-icon').classList.add(newOrder === 'asc' ? 'fa-sort-up' : 'fa-sort-down');
                });
            });

            function fetchData(page = 1, sortColumn = '', sortOrder = '') {
                const url = new URL('fetch_data.php', window.location.href);
                url.searchParams.set('page', page);
                if (sortColumn) {
                    url.searchParams.set('sortColumn', sortColumn);
                    url.searchParams.set('sortOrder', sortOrder);
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('#dataTable tbody');
                        tbody.innerHTML = '';
                        data.data.forEach(row => {
                            const tr = document.createElement('tr');
                            Object.keys(row).forEach(key => {
                                const td = document.createElement('td');
                                td.textContent = row[key];
                                tr.appendChild(td);
                            });

                            if (document.querySelector("#tableSelect").value !== "history") {
                                const actionsTd = document.createElement('td');
                                actionsTd.classList.add('actions');
                                const deleteBtn = document.createElement('button');
                                deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'deleteBtn');
                                deleteBtn.dataset.id = row.id;
                                deleteBtn.textContent = 'Delete';
                                actionsTd.appendChild(deleteBtn);
                                tr.appendChild(actionsTd);
                            }

                            tbody.appendChild(tr);
                        });

                        document.getElementById('currentPage').textContent = data.page;
                        // Handle pagination buttons based on data.totalPages

                        bindDeleteButtonEvent(); // Re-bind delete button click event after updating table rows
                    });
            }

            function bindDeleteButtonEvent() {
                document.querySelectorAll('.deleteBtn').forEach(button => {
                    button.removeEventListener('click', handleDelete); // Ensure previous event is removed
                    button.addEventListener('click', handleDelete);
                });
            }

            function handleDelete(event) {
                const id = event.target.dataset.id;
                if (confirm('Are you sure you want to delete this row?')) {
                    fetch('delete_row.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                id: id
                            })
                        })
                        .then(response => response.text())
                        .then(() => {
                            fetchData(document.getElementById('currentPage').textContent); // Fetch data for the current page
                        });
                }
            }

            fetchData(); // Initial fetch
        });
    </script>
</body>

</html>