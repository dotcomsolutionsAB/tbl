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
    
    <nav>
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
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint rem hic recusandae adipisci in. Eveniet, veritatis sapiente facere repudiandae vel deserunt. Eos porro eveniet unde animi, omnis, asperiores autem minus alias fuga ad laboriosam, assumenda eius vero obcaecati doloremque repellendus! Aspernatur reiciendis dolores cupiditate accusamus veritatis corrupti a culpa facere dolorem error tempore ab labore itaque ea, dolor maxime rerum sunt ipsum ullam. Quos libero blanditiis eos, iusto et explicabo debitis dolorum tempore minima nihil saepe accusamus recusandae natus minus veniam cupiditate hic magni illum commodi vel labore ipsum! Voluptate tenetur architecto expedita voluptatem provident obcaecati. Voluptates laudantium officia beatae, quia illo tenetur quisquam delectus odit placeat! Voluptates, nobis tempora cupiditate esse voluptate aliquid fugiat ipsam neque magnam, corrupti, commodi aut! Cum nemo obcaecati sequi odit sapiente doloremque quo ullam temporibus ducimus eaque rerum ea magnam, harum eius nobis vel enim maiores, autem in, vitae qui rem dolores. Adipisci, est. Fugiat doloremque pariatur perspiciatis magni eaque dignissimos necessitatibus! Corrupti impedit ipsam velit eveniet quisquam quis odio distinctio recusandae dolor quaerat deserunt asperiores ad aperiam earum, voluptatum temporibus omnis laborum sed delectus, magnam sequi quae consequatur! Tempora laudantium error odit autem dolorem architecto dolorum similique nemo. Facilis maxime, eos nam animi numquam ex laborum accusamus dicta veniam hic quaerat fuga obcaecati, laudantium sapiente libero corrupti veritatis odit itaque deleniti magnam expedita tempore. Perferendis optio nobis maxime esse repellendus porro explicabo vitae dolorum quibusdam vero doloremque, dolor saepe reprehenderit ipsa ab magni eius recusandae est doloribus nostrum quam exercitationem adipisci! Porro, harum molestiae. Ab nemo enim labore commodi possimus recusandae error neque suscipit ratione vitae? Dolores earum accusamus ab nobis necessitatibus a pariatur, nisi delectus id molestias? Perferendis sapiente quos repudiandae, totam eaque officiis maxime neque fugiat, beatae dicta quam error optio sunt nesciunt amet nostrum soluta mollitia eligendi magnam tenetur impedit.</p>
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