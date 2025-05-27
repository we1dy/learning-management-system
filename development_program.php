<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBCom Dashboard</title>
    <link href="https://fonts.cdnfonts.com/css/aileron" rel="stylesheet">
    <script src="https://kit.fontawesome.com/538907d71c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/employee.css"><link rel="stylesheet" href="employee.css">
</head>

<body>
    <header>
        <div class="logo"><a href=""><img src="assets/images/logo.png" width="220px"></a></div>
        <div class="header-right">
            <input type="text" class="search-box" placeholder="Search...">
            <div class="user-info" onclick="toggleDropdown()">
                <span>Lady Arboleda</span>
                <div id="userDropdown" class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Log Out</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <nav class="sidebar">
            <div class="sidebar-section">
                <ul>
                    <li class="" onclick="showDashboard()">Dashboard</li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Courses</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" onclick="showContent('regulatory')">Regulatory Courses</a>
                            <a class="dropdown-item" onclick="showContent('onboarding')">On-Boarding Orientation</a>
                            <a class="dropdown-item" onclick="showContent('behavioural')">Behavioural and Management Training</a>
                            <a class="dropdown-item" onclick="showContent('development')">Development Program</a>
                            <a class="dropdown-item" onclick="showContent('technical')">Technical/Job-Specific Systems</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>


        <main class="main-content">
            <!-- Development Program Content -->
            <div id="development-content" class="content-section">
                <div class="course-header">DEVELOPMENT PROGRAM</div>
                <div class="course-grid">
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+1')"></div>
                        <h3>Advanced Leadership</h3>
                        <p>For senior managers and executives</p>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+2')"></div>
                        <h3>Strategic Thinking</h3>
                        <p>Developing long-term business strategies</p>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+3')"></div>
                        <h3>Financial Analysis</h3>
                        <p>Advanced financial statement analysis</p>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+4')"></div>
                        <h3>Digital Transformation</h3>
                        <p>Leading digital initiatives in banking</p>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+5')"></div>
                        <h3>Innovation Management</h3>
                        <p>Fostering innovation in financial services</p>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background-image: url('https://via.placeholder.com/300x120?text=Development+6')"></div>
                        <h3>Executive Presence</h3>
                        <p>Developing leadership gravitas</p>
                    </div>
                </div>
                <div class="pagination">
                    <button class="active">1</button>
                </div>
            </div>
        </main>
    </div>
            
    <footer>
        <p>Log Out</p>
    </footer>

    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>

