<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="table_cdn/Datatables/dataTables.css">
    <title>Admin Dashboard</title>
</head>

<body>
    
    <nav class="navv">
        <div class="logo">
            <div class="logo-image">
                <img src="logo.png" alt="">
            </div>
        </div>
        <div class="menu-items">
            <ul class="navLinks">
                <li class="navList active">
                    <a href="#">
                        <ion-icon name="home-outline"></ion-icon>
                        <span class="links">Dashboard</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="#">
                        <ion-icon name="folder-outline"></ion-icon>
                        <span class="links">Content</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="#">
                        <ion-icon name="analytics-outline"></ion-icon>
                        <span class="links">Analytics</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="#">
                        <ion-icon name="heart-outline"></ion-icon>
                        <span class="links">Likes</span>
                    </a>
                </li>
                <li class="navList">
                    <a href="#">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                        <span class="links">Comments</span>
                    </a>
                </li>
            </ul>
            <ul class="bottom-link">
                <li>
                    <a href="#">
                        <ion-icon name="person-circle-outline"></ion-icon>
                        <span class="links">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="log-out-outline"></ion-icon>
                        <span class="links">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="container">
            <div class="overview">
                <div class="title">
                    <ion-icon name="speedometer"></ion-icon>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">

                    <div class="box box1">
                        <div class="divv">
                            <ion-icon name="eye-outline"></ion-icon>
                            <span class="text">Total Views</span>
                        </div>
                        <span class="number">18345</span>
                    </div>

                    <div class="box box2">
                        <div class="divv">
                            <ion-icon name="people-outline"></ion-icon>
                            <span class="text">Active users</span>
                        </div>
                        <span class="number">2745</span>
                    </div>

                    <div class="box box3">
                        <div class="divv">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                            <span class="text">Total Activities</span>
                        </div>
                        <span class="number">1209</span>
                    </div>

                    <div class="box box4">
                        <div class="divv">
                            <ion-icon name="car-sport-outline"></ion-icon>
                            <span class="text">Insured Vehicles</span>
                        </div>
                        <span class="number">123</span>
                    </div>
                    
                </div> 
            </div>
            

            <!-- Recent Activities -->
            <div class="data-table activityTable">
                <div class="title">
                    <ion-icon name="time-outline"></ion-icon>
                    <span class="text">Recent Activities</span>
                </div>
                <div class="table_">
                    <!-- Enter any table or section here -->
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>Column 1</th>
                                <th>Column 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Row 1 Data 1</td>
                                <td>Row 1 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Content -->
            <div style="display:none" class="data-table userDetailsTable">
                <div class="title">
                    <ion-icon name="folder-outline"></ion-icon>
                    <span class="text">Content</span>
                </div>
                <div class="table_">
                    <!-- Enter any table or section here -->
                </div>
            </div>

            <!-- Analytics -->
            <div style="display:none" class="data-table EditUserRole">
                <div class="title">
                    <ion-icon name="analytics-outline"></ion-icon>
                    <span class="text">Analytics</span>
                </div>
                <div class="table_">
                    <!-- Enter any table or section here -->
                </div>
            </div>

            <!--  Likes -->
            <div style="display:none" class="data-table VehicleDetails">
                <div class="title">
                    <ion-icon name="heart-outline"></ion-icon>
                    <span class="text">Vehicles</span>
                </div>
                <div class="table_">
                    <!-- Enter any table or section here -->
                </div>
            </div>

            <!-- Downloads section -->
            <div style="display:none" class="data-table downloads">
                <div class="title">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                    <span class="text">Comments</span>
                </div>
                <div class="table_">
                    <!-- Enter any table or section here -->
                </div>
            </div>

        </div>
    </section>

    <script src="index.js"></script>
    
    <!-- Sources for icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
    
    <!-- for table -->
    <script src="table_cdn/jquery/jquery-3.7.1.min.js"></script>
    <script src="table_cdn/Datatables/dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
</body>

</html>