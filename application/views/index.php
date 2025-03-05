<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/animate.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/boxicons.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/magnific-popup.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/meanmenu.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/fancybox.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/odometer.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/scrollCue.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/style.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/dark.css">
      <link rel="stylesheet" href="<?php echo base_url();?>frontend/css/responsive.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title><?php echo html_escape($title);?></title>
      <link rel="icon" type="image/webp" href="<?php echo base_url();?>frontend/images/logo-2.png">
   </head>
   <body>
      <div class="preloader">
         <div class="loader">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>
            <span>Restaurant</span>
         </div>
      </div>
      <div class="switch-theme-mode">
         <label id="switch" class="switch">
         <input type="checkbox" onchange="toggleTheme()" id="slider">
         <span class="slider round"></span>
         </label>
      </div>
      <div class="navbar-area">
         <div class="container">
            <div class="mobile-nav">
               <div class="logo">
                  <a href="<?php echo base_url();?>">
                  <img src="<?php echo base_url();?>frontend/images/logo.png" class="logo-light" alt="images">
                  <img src="<?php echo base_url();?>frontend/images/logo.png" class="logo-dark" alt="images">
                  </a>
               </div>
            </div>
         </div>
         <div class="main-nav">
            <div class="container-fluid">
               <nav class="navbar navbar-expand-md navbar-light">
                  <a href="index.php">
                  <img src="<?php echo base_url();?>frontend/images/logo.png" class="logo-light" alt="images" width="100" height="100">
                  <img src="<?php echo base_url();?>frontend/images/logo.png" class="logo-dark" alt="images" width="100" height="100">
                  </a>
                  <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                     <ul class="navbar-nav ms-auto">
                        <?php 
                           $allmenu=$this->allmenu; 
                           foreach($allmenu as $menu){
                              $activeclass='';
                              if($menu->menu_name=='Home'){
                              $activeclass='active';
                              $href=base_url().'';
                              }
                              else{
                              $activeclass='';
                              $href=base_url().''.$menu->menu_slug;
                              }
                           ?>
                        <li class="nav-item nav-item-five">   
                           <a href="<?php echo base_url().''.html_escape($menu->menu_slug);?>" class="nav-link dropdown-toggle <?php echo html_escape($activeclass);?>">
                           <?php echo html_escape($menu->menu_name);?>
                           </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                           <a href="#" class="nav-link dropdown-toggle">
                           Languages
                           <i class='bx bx-plus'></i>
                           </a>
                           <ul class="dropdown-menu">
                           <li class="nav-item">
                              <a href="<?php echo base_url("hotel/switchLang/english"); ?>" class="nav-link">English</a>
                           </li>
                           <li class="nav-item">
                              <a href="<?php echo base_url("hotel/switchLang/vietnamese"); ?>" class="nav-link">Vietnamese</a>
                           </li>
                            <li class="nav-item">
                              <a href="<?php echo base_url("hotel/switchLang/spanish"); ?>" class="nav-link">Spanish</a>
                           </li>
                           </ul>
                        </li>
                     </ul>
                     <div class="others-option-vg d-flex align-items-center">
                        <!-- <div class="option-item">
                           <i class='bx bx-search search-btn'></i>
                           <i class='bx bx-x close-btn'></i>
                           <div class="search-overlay search-popup">
                              <div class='search-box'>
                                 <form class="search-form">
                                    <input class="search-input" placeholder="Search..." type="text">
                                    <button class="search-button" type="submit">
                                    <i class='bx bx-search'></i>
                                    </button>
                                 </form>
                              </div>
                           </div>
                        </div> -->
                        <div class="option-item">
                           <div class="shapping-bag">
                              <a href="<?php echo base_url('hotel/cart');?>">
                              <img src="<?php echo base_url();?>frontend/images/shopping-bag-icon.svg" alt="images">
                              </a>
                              <div class="shapping-text">
                                 <?php 
                                    if(!empty($count_products)){
                                       echo count($count_products);
                                    } else{
                                       echo "0";
                                    }
                                 ?>
                              </div>
                           </div>
                        </div>
                        <div class="option-item">
                           <?php if($this->session->userdata('UserID')== FALSE){?>
                           <a href="<?php echo base_url('user/login');?>" class="default-btn"><?php echo $this->lang->line('0') ?></a>
                           <?php }
                        else{
                         ?>
                         <a href="<?php echo base_url('hotel/viewtable');?>" class="default-btn"><?php echo $this->lang->line('0') ?></a>
                          <?php } ?>
                        </div>
                        &nbsp;&nbsp;
                        <div class="option-item">
                          
                            <li class="nav-item nav-item-five">
                          <?php if($this->session->userdata('UserID')== FALSE){?>
                           <a href="<?php echo base_url('user/login');?>" class="default-btn"><i class="fa fa-sign-in" style="font-size:18px"></i> <?php echo display('sign_in') ?></a>
                          <?php }
                        else{
                         ?>
                         <a href="<?php echo base_url('user/logout');?>" class="default-btn"><i class="fa fa-sign-in" style="font-size:18px"></i><?php echo display('logout') ?></a>
                          <?php } ?>
                      </li>
                        </div>
                       
                     </div>
                  </div>
               </nav>
            </div>
         </div>
         <div class="others-option-for-responsive">
            <div class="container">
               <div class="dot-menu">
                  <div class="inner">
                     <div class="circle circle-one"></div>
                     <div class="circle circle-two"></div>
                     <div class="circle circle-three"></div>
                  </div>
               </div>
               <div class="container">
                  <div class="option-inner">
                     <div class="others-option justify-content-center d-flex align-items-center">
                        <!-- <div class="option-item">
                           <i class='bx bx-search search-btn'></i>
                           <i class='bx bx-x close-btn'></i>
                           <div class="search-overlay search-popup">
                              <div class='search-box'>
                                 <form class="search-form">
                                    <input class="search-input" placeholder="Search..." type="text">
                                    <button class="search-button" type="submit">
                                    <i class='bx bx-search'></i>
                                    </button>
                                 </form>
                              </div>
                           </div>
                        </div> -->
                        <div class="option-item">
                           <div class="shapping-bag">
                              <a href="cart.php">
                              <img src="<?php echo base_url();?>frontend/images/shopping-bag-icon.svg" alt="images">
                              </a>
                              <div class="shapping-text">
                                 <?php 
                                    if(!empty($count_products)){
                                       echo count($count_products);
                                    } else{
                                       echo "0";
                                    }
                                 ?>
                              </div>
                           </div>
                        </div>
                       <div class="option-item">
                           <?php if($this->session->userdata('UserID')== FALSE){?>
                           <a href="<?php echo base_url('user/login');?>" class="default-btn"><?php echo $this->lang->line('0') ?></a>
                           <?php }
                        else{
                         ?>
                         <a href="<?php echo base_url('hotel/viewtable');?>" class="default-btn"><?php echo $this->lang->line('0') ?></a>
                          <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
<!--      <div id="carouselExampleCaptions" class="carousel slide" data-mdb-ride="carousel">-->
<!--  <div class="carousel-indicators">-->
<!--    <button-->
<!--      type="button"-->
<!--      data-mdb-target="#carouselExampleCaptions"-->
<!--      data-mdb-slide-to="0"-->
<!--      class="active"-->
<!--      aria-current="true"-->
<!--      aria-label="Slide 1"-->
<!--    ></button>-->
<!--    <button-->
<!--      type="button"-->
<!--      data-mdb-target="#carouselExampleCaptions"-->
<!--      data-mdb-slide-to="1"-->
<!--      aria-label="Slide 2"-->
<!--    ></button>-->
<!--    <button-->
<!--      type="button"-->
<!--      data-mdb-target="#carouselExampleCaptions"-->
<!--      data-mdb-slide-to="2"-->
<!--      aria-label="Slide 3"-->
<!--    ></button>-->
<!--  </div>-->
<!--  <div class="carousel-inner">-->
<!--    <div class="carousel-item active">-->
<!--      <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="d-block w-100" alt="Wild Landscape"/>-->
<!--      <div class="carousel-caption d-none d-md-block">-->
<!--        <h5>First slide label</h5>-->
<!--        <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>-->
<!--      </div>-->
<!--    </div>-->
<!--    <div class="carousel-item">-->
<!--      <img src="https://mdbcdn.b-cdn.net/img/new/slides/042.webp" class="d-block w-100" alt="Camera"/>-->
<!--      <div class="carousel-caption d-none d-md-block">-->
<!--        <h5>Second slide label</h5>-->
<!--        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>-->
<!--      </div>-->
<!--    </div>-->
<!--    <div class="carousel-item">-->
<!--      <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="d-block w-100" alt="Exotic Fruits"/>-->
<!--      <div class="carousel-caption d-none d-md-block">-->
<!--        <h5>Third slide label</h5>-->
<!--        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--  <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="prev">-->
<!--    <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--    <span class="visually-hidden">Previous</span>-->
<!--  </button>-->
<!--  <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="next">-->
<!--    <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--    <span class="visually-hidden">Next</span>-->
<!--  </button>-->
<!--</div>-->

      <div class="banner-area">
         <div class="container-fluid">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="single-banner-content">
                     <span data-cue="slideInUp" data-duration="800"><?php echo $this->lang->line('1') ?></span>
                     <h1 data-cue="slideInUp" data-duration="1800"><?php echo $this->lang->line('2') ?></h1>
                     <p data-cue="slideInUp" data-duration="2000"><?php echo $this->lang->line('3') ?></p>
                      <a href="about.php" class="default-btn" data-cue="slideInUp" data-duration="2500"><?php echo $this->lang->line('4') ?></a> 
                  </div>
               </div>
               <div class="col-lg-6" data-cue="zoomIn" data-duration="2000">
                  <div id="slider" class="single-banner-image">
                    
                   <div class="slides">  
                     <img src="<?php echo base_url();?>frontend/images/banner/banner.png" alt="images">
                   </div>
                   <div class="slides">  
                     <img src="<?php echo base_url();?>frontend/images/banner/banner1.png" alt="images">
                   </div>
                        <div id="dot"><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="banner-shape-1">
            <img src="<?php echo base_url();?>frontend/images/banner/banner-shape-1.webp" alt="images">
         </div>
         <div class="banner-shape-2">
            <img src="<?php echo base_url();?>frontend/images/banner/banner-shape-2.webp" alt="images">
         </div>
         <div class="banner-shape-3">
            <img src="<?php echo base_url();?>frontend/images/banner/banner-shape-3.webp" alt="images">
         </div>
         <div class="banner-shape-4">
            <img src="<?php echo base_url();?>frontend/images/banner/banner-shape-4.webp" alt="images">
         </div>
         <div class="banner-shape-5">
            <img src="<?php echo base_url();?>frontend/images/banner/banner-shape-5.webp" alt="images">
         </div>
      </div>
      <div class="discover-area pt-100 pb-70">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="single-discover-card">
                     <img src="<?php echo base_url();?>frontend/images/discover/discover-1.webp" alt="images">
                     <h3><?php echo $this->lang->line('4') ?></h3>
                     <p><?php echo $this->lang->line('5') ?></p>
                     <a href="#" class="discover-more"><?php echo $this->lang->line('6') ?></a>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="single-discover-card">
                     <img src="<?php echo base_url();?>frontend/images/discover/discover-2.webp" alt="images">
                     <h3><?php echo $this->lang->line('7') ?></h3>
                     <p><?php echo $this->lang->line('5') ?></p>
                     <a href="#" class="discover-more"><?php echo $this->lang->line('6') ?></a>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="single-discover-card">
                     <img src="<?php echo base_url();?>frontend/images/discover/discover-3.webp" alt="images">
                     <h3><?php echo $this->lang->line('8') ?></h3>
                     <p><?php echo $this->lang->line('5') ?></p>
                     <a href="#" class="discover-more"><?php echo $this->lang->line('6') ?></a>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="single-discover-card">
                     <img src="<?php echo base_url();?>frontend/images/discover/discover-4.webp" alt="images">
                     <h3><?php echo $this->lang->line('9') ?></h3>
                     <p><?php echo $this->lang->line('5') ?></p>
                     <a href="#" class="discover-more"><?php echo $this->lang->line('6') ?></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="about-area pt-100 pb-100">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6" data-cue="slideInLeft" data-duration="800">
                  <div class="about-image">
                     <img src="<?php echo base_url();?>frontend/images/about/food.png" alt="images">
                  </div>
               </div>
               <div class="col-lg-6" data-cue="slideInRight" data-duration="800">
                  <div class="single-about-content">
                     <div class="section-title left-title">
                        <span class="top-title"><?php echo $this->lang->line('10') ?></span>
                        <h2><?php echo $this->lang->line('11') ?></h2>
                        <p><?php echo $this->lang->line('12') ?>
                        </p>
                     </div>
                     <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-6">
                           <div class="speciallst-card">
                              <h3 style="font-size: 20px !important;"><img src="<?php echo base_url();?>frontend/images/about/about-img-3.webp" alt="images"><?php echo $this->lang->line('13') ?></h3>
                              
                                <ul style="margin-top: 40px;">
                                    <li><i class='bx bx-right-arrow-circle'></i><?php echo $this->lang->line('14') ?></li>
                                    
                                </ul>
                           </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6">
                           <div class="speciallst-card">
                              <h3 style="font-size: 18px !important;"><img src="<?php echo base_url();?>frontend/images/about/about-img-4.webp" alt="images"><?php echo $this->lang->line('15') ?></h3>
                              <ul>
                                   
                                    <li><i class='bx bx-right-arrow-circle'></i><?php echo $this->lang->line('16') ?></li>
                                </ul>
                              
                     </ul></h3>
                              
                           </div>
                        </div>
                     </div>
                     <!--<ul>-->
                     <!--   <li><i class='bx bx-right-arrow-circle'></i>Dine in: Noodle Soups & Pho, Starters, Drinks</li>-->
                     <!--   <li><i class='bx bx-right-arrow-circle'></i>Online order, On time delivery, Perfect packaging</li>-->
                     <!--</ul>-->
                     <!-- <a href="booking-table.php" class="default-btn">Booking Now</a> -->
                  </div>
               </div>
            </div>
         </div>
         <div class="about-shape-1">
            <img src="<?php echo base_url();?>frontend/images/about/about-shape-1.webp" alt="images">
         </div>
         <div class="about-shape-2">
            <img src="<?php echo base_url();?>frontend/images/about/about-shape-2.webp" alt="images">
         </div>
         <div class="about-shape-3">
            <img src="<?php echo base_url();?>frontend/images/about/about-shape-3.webp" alt="images">
         </div>
         <div class="about-shape-4">
            <img src="<?php echo base_url();?>frontend/images/about/about-shape-4.webp" alt="images">
         </div>
      </div>
      <div class="special-menu-area pt-100 pb-100 flag_bef">
         <div class="container">
            <div class="section-title">
               <span class="top-title" style="font-size: 30px !important; line-height: 40px !important;"><?php echo $this->lang->line('17') ?></span>
               <h2><?php echo $this->lang->line('18') ?></h2>
            </div>
            <div class="special-menu-tabs">
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><?php echo $this->lang->line('19') ?></button>
                  </li>
                 <!--  <li class="nav-item" role="presentation">
                     <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Starters & Drinks</button>
                  </li> -->
                 <!--  <li class="nav-item" role="presentation">
                     <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Drinks</button>
                  </li> -->
                 <!--  <li class="nav-item" role="presentation">
                     <button class="nav-link" id="coffee-tab" data-bs-toggle="tab" data-bs-target="#coffee-tab-pane" type="button" role="tab" aria-controls="coffee-tab-pane" aria-selected="false">Starters & Drinks</button>
                  </li> -->
                  <!-- <li class="nav-item" role="presentation">
                     <button class="nav-link" id="chocolate-tab" data-bs-toggle="tab" data-bs-target="#chocolate-tab-pane" type="button" role="tab" aria-controls="chocolate-tab-pane" aria-selected="false">Chocolate</button>
                  </li> -->
               </ul>
               <div class="tab-content" id="myTabContent">
                  <form id="insert_data" method="post">
                  <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                     <div class="single-special-menu-content">
                        <div class="row">
                           <?php $s=0; foreach ($menu_items as $item) { ?>
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <img src="<?php echo base_url($item->ProductImage);?>" alt="images">
                                       </div>
                                      <!--  <div class="add-to-card">
                                          <a href="cart.php" class="default-btn">Add To Cart</a>
                                       </div> -->
                                    </div>
                                    <div class="col-lg-6 col-6">
                                       <div class="special-menu-text">
                                          <h3 name="ProductName"><?php echo $item->ProductName; ?></h3>
                                          <input type="hidden" name="ProductName" value="<?php echo $item->ProductName; ?>">
                                          <p name="descrip"><?php echo $item->descrip; ?></p>
                                          <input type="hidden" name="descrip" value="<?php echo $item->descrip; ?>">
                                          <br>
                                          <!-- <button type="submit" class="default-btn">Add To Cart</button></a> -->
                                           <a  href="<?php echo base_url('hotel/insert_items/'.$item->ProductsID);?>" class="default-btn add_items"><?php echo $this->lang->line('20') ?><span></span></a>
                                         <!--  <div class="row">
                                             <div class="col-md-6">
                                                <input type="number" name="quantity" value="1" class="form-control">
                                                 
                                             </div>
                                             <div class="col-md-6">
                                                
                                                <a  href="<?php //echo base_url('hotel/insert_items/'.$item->ProductsID);?>" class="default-btn add_items">Add to Cart<span></span></a>
                                             </div>
                                          </div> -->
                                          
                                          <input type="hidden" name="ProductsID" value="<?php echo $item->ProductsID; ?>">
                                          <input type="hidden" name="variantid" value="<?php echo $item->variantid; ?>">
                                          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>
                                             <?php if($currency->position==1){echo $currency->curr_icon;}?>
                                             <?php echo $item->price;?>
                                             <input type="hidden" name="price" value="<?php echo $item->price; ?>">
                                             <?php if($currency->position==2){echo $currency->curr_icon;}?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php $s++; } ?>  
                        </div>
                     </div>
                  </div>
                  </form>
<!--                    <div class="tab-pane fade" id="coffee-tab-pane" role="tabpanel" aria-labelledby="coffee-tab" tabindex="0">
                     <div class="single-special-menu-content">
                        <div class="row align-items-center">
                           <?php //$s=0; //foreach ($menu_items as $key => $item) { ?>
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <a href="menu-details.html">
                                          <img src="<?php//echo base_url($item->ProductImage);?>" alt="images">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                      <div class="special-menu-text">
                                          <h3 name="ProductName"><?php //echo $item->ProductName; ?></h3>
                                          <input type="hidden" name="ProductName" value="<?php //echo $item->ProductName; ?>">
                                          <p name="descrip"><?php //echo $item->descrip; ?></p>
                                          <input type="hidden" name="descrip" value="<?php //echo $item->descrip; ?>">
                                          <br>
                                          
                                           <a  href="<?php //echo base_url('hotel/insert_items/'.$item->ProductsID);?>" class="default-btn add_items">Add to Cart<span></span></a>
                                          
                                          <input type="hidden" name="ProductsID" value="<?php //echo $item->ProductsID; ?>">
                                          <input type="hidden" name="variantid" value="<?php //echo $item->variantid; ?>">
                                          <input type="hidden" name="<?php //echo $this->security->get_csrf_token_name();?>" value="<?php //echo $this->security->get_csrf_hash();?>">
                                       </div>
                                    </div>
                                     <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>
                                             <?php //if($currency->position==1){echo $currency->curr_icon;}?>
                                             <?php //echo $item->price;?>
                                             <input type="hidden" name="price" value="<?php //echo $item->price; ?>">
                                             <?php //if($currency->position==2){echo $currency->curr_icon;}?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php //$s++; } ?>
                        </div>
                     </div>
                  </div> -->
                  <!-- <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                     <div class="single-special-menu-content">
                        <div class="row justify-content-center">
                           <?php //$s=0; foreach ($catsub_items as $key => $catsub_item) { ?>
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <img src="<?php //echo base_url($catsub_item->ProductImage);?>" alt="images">
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                       <div class="special-menu-text">
                                          <h3><?php //echo $catsub_item->ProductName; ?></h3>
                                          <p><?php //echo $catsub_item->descrip; ?></p>
                                          <br>
                                          <button type="submit" class="default-btn">Add To Cart</button>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>
                                             <?php //if($currency->position==1){echo $currency->curr_icon;}?>
                                             <?php //echo $catsub_item->price;?>
                                             <?php //if($currency->position==2){echo $currency->curr_icon;}?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                         <?php //$s++; } ?>
                        </div>
                     </div>
                  </div> -->
                 
                 <!--  <div class="tab-pane fade" id="chocolate-tab-pane" role="tabpanel" aria-labelledby="chocolate-tab" tabindex="0">
                     <div class="single-special-menu-content">
                        <div class="row justify-content-center">
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <a href="menu-details.html">
                                          <img src="assets/images/menu/menu-page-img-6.webp" alt="images">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                       <div class="special-menu-text">
                                          <a href="menu-details.html">
                                             <h3>Cappucino</h3>
                                          </a>
                                          <p>1/2 milk, 1/2 espresso, ice, caramel</p>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>$28</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <a href="menu-details.html">
                                          <img src="assets/images/menu/menu-page-img-1.webp" alt="images">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                       <div class="special-menu-text">
                                          <a href="menu-details.html">
                                             <h3>Vieness Veal Cultech</h3>
                                          </a>
                                          <p>Fresh beware coffe</p>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>$32</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-6 col-md-6">
                              <div class="special-card">
                                 <div class="row align-items-center">
                                    <div class="col-lg-3 col-4">
                                       <div class="special-menu-img">
                                          <a href="menu-details.html">
                                          <img src="assets/images/menu/menu-page-img-2.webp" alt="images">
                                          </a>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                       <div class="special-menu-text">
                                          <a href="menu-details.html">
                                             <h3>Sea Bass Ceviche</h3>
                                          </a>
                                          <p>2/3 streamed milk, 1/3 espresso</p>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-2">
                                       <div class="special-menu-number">
                                          <span>$32</span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> -->
               </div>
            </div>
         </div>
      </div>
      <div class="odometer-area pt-100 pb-100">
         <div class="container">
            <div class="row">
               <div class="col-lg-2 col-12 col-sm-2 col-md-2" data-cues="fadeIn" data-duration="1500">
                  <div class="fun-odometer">
                     <h2>
                        <span class="odometer" data-count="287">00</span>
                        <span class="target">+</span>
                     </h2>
                    <p><?php echo $this->lang->line('21') ?></p>
                  </div>
               </div>
               <div class="col-lg-10 col-sm-10 col-md-10">
                  <div class="row">
                     <div class="col-lg-3 col-6 col-sm-3 col-md-3" data-cues="fadeIn" data-duration="1500">
                        <div class="fun-odometer">
                           <h2>
                              <span class="odometer" data-count="45">00</span>
                              <span class="target">+</span>
                           </h2>
                           <p><?php echo $this->lang->line('22') ?></p>
                        </div>
                     </div>
                     <div class="col-lg-3 col-6 col-sm-3 col-md-3" data-cues="fadeIn" data-duration="1500">
                        <div class="fun-odometer">
                           <h2>
                              <span class="odometer" data-count="70">00</span>
                              <span class="target">+</span>
                           </h2>
                           <p><?php echo $this->lang->line('23') ?></p>
                        </div>
                     </div>
                     <div class="col-lg-3 col-6 col-sm-3 col-md-3" data-cues="fadeIn" data-duration="1500">
                        <div class="fun-odometer">
                           <h2>
                              <span class="odometer" data-count="130">00</span>
                              <span class="target">+</span>
                           </h2>
                           <p><?php echo $this->lang->line('24') ?></p>
                        </div>
                     </div>
                     <div class="col-lg-3 col-6 col-sm-3 col-md-3" data-cues="fadeIn" data-duration="1500">
                        <div class="fun-odometer">
                           <h2>
                              <span class="odometer" data-count="25">00</span>
                              <span class="target">+</span>
                           </h2>
                           <p><?php echo $this->lang->line('25') ?></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="testimonials-area">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6 col-md-6">
                  <div class="single-testimonials-content">
                     <div class="section-title left-title">
                        <span class="top-title"><?php echo $this->lang->line('26') ?></span>
                        <h2><?php echo $this->lang->line('27') ?></h2>
                     </div>
                     <div class="testimonials-slider owl-carousel owl-theme">
                        <div class="testimonials-card">
                           <div class="testimonials-text">
                              <img src="<?php echo base_url();?>frontend/images/testimonials/testimonials-2.webp" alt="images">
                              <h3><?php echo $this->lang->line('28') ?></h3>
                              <span><?php echo $this->lang->line('29') ?></span>
                              <div class="testimonials-shape-1">
                                 <img src="<?php echo base_url();?>frontend/images/testimonials/testimonials-shape.webp" alt="images">
                              </div>
                           </div>
                           <p><?php echo $this->lang->line('30') ?></p>
                        </div>
                        <div class="testimonials-card">
                           <div class="testimonials-text">
                              <img src="<?php echo base_url();?>frontend/images/testimonials/testimonials-2.webp" alt="images">
                             <h3><?php echo $this->lang->line('28') ?></h3>
                              <span><?php echo $this->lang->line('29') ?></span>
                              <div class="testimonials-shape-1">
                                 <img src="<?php echo base_url();?>frontend/images/testimonials/testimonials-shape.webp" alt="images">
                              </div>
                           </div>
                           <p><?php echo $this->lang->line('30') ?></p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-md-6">
                  <div class="testimonials-img">
                     <img src="<?php echo base_url();?>frontend/images/testimonials/people.png" alt="images">
                     <!-- <div class="testimonials-video">
                        <a href="https://www.youtube.com/watch?v=PtOOI_nKwtw" class="popup-youtube">
                        <img src="<?php //echo base_url();?>frontend/images/video-play.svg" alt="images">
                        </a>
                     </div> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="portfolio-area pt-100 pb-100 jarallax" data-jarallax='{"speed": 0.3}'>
         <div class="container">
            <div class="section-title">
               <span class="top-title"><?php echo $this->lang->line('31') ?></span>
               <h2><?php echo $this->lang->line('32') ?></h2>
            </div>
            <div class="portfolio-slider owl-carousel owl-theme">
               <?php $s=0; foreach ($menu_items as $key => $item) { ?>
               <div class="single-portfolio-item">
                  <div class="portfolio-img">
                     <img src="<?php echo base_url($item->ProductImage);?>" alt="images">
                  </div>
                  <div class="portfolio-card">
                     <!--  <div class="portfolio-icon">
                        <a data-fancybox="gallery" href="<?php echo base_url();?>frontend/images/dish/proto/special beef pho.png">
                        <i class='bx bx-plus'></i>
                        </a>
                        </div> -->
                     <!-- <span><?php echo $item->ProductName;?></span>     -->
                     <!-- <a href=""> -->
                     <h3><?php echo $item->ProductName;?></h3>
                     <!-- </a> -->
                  </div>
               </div>
               <?php $s++; } ?>
            </div>
         </div>
         <div class="portfolio-shape">
            <img src="<?php echo base_url();?>frontend/images/portfolio/portfolio-shape-1.webp" alt="images">
         </div>
      </div>
      <!--  <div class="visit-us-today-area pt-100">
         <div class="container">
            <div class="row">
               <div class="col-lg-6">
                  <div class="visit-images">
                     <div class="visit-main-img" data-cue="bounceInLeft" data-duration="2000">
                        <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-img-1.webp" alt="images">
                     </div>
                     <div class="visit-shape-1">
                        <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-shape-1.webp" alt="images">
                     </div>
                     <div class="visit-shape-2">
                        <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-shape-3.webp" alt="images">
                     </div>
                  </div>
               </div>
               <div class="col-lg-6" data-cue="bounceInRight" data-duration="1500">
                  <div class="reserve-from">
                     <div class="section-title left-title">
                        <span class="top-title">Visit Us Today</span>
                        <h2>Make A Reserve</h2>
                     </div>
                     <form>
                        <div class="row">
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <input type="text" class="form-control" placeholder="Name">
                              </div>
                           </div>
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <input type="text" class="form-control" placeholder="Phone">
                              </div>
                           </div>
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <select class="form-select" aria-label="Default select example">
                                    <option selected>Persons</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <div class="input-group date" id="datetimepicker">
                                    <input type="text" class="form-control" placeholder="mm/dd/yyyy">
                                    <span class="input-group-addon"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <div class="form-group">
                                 <select class="form-select" aria-label="Default select example">
                                    <option selected>Time</option>
                                    <option value="1">08:00 AM – 05:00 PM</option>
                                    <option value="2">09:00 AM – 06:00 PM</option>
                                    <option value="3">10:00 AM – 05:00 PM</option>
                                    <option value="4">09:00 AM – 05:00 PM</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-lg-12 col-sm-6 col-md-6">
                              <button type="submit" class="default-btn">Book A Table</button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div class="visit-shape-3">
            <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-shape-2.webp" alt="images">
         </div>
         <div class="visit-shape-4">
            <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-shape-4.webp" alt="images">
         </div>
         <div class="visit-shape-5">
            <img src="<?php echo base_url();?>frontend/images/reserve-today/reserve-shape-5.webp" alt="images">
         </div>
         </div> -->
      <!-- <div class="location-area pt-100 pb-100 jarallax" data-jarallax='{"speed": 0.3}'>
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-6" data-cue="slideInLeft" data-duration="2000">
                  <div class="single-location-content">
                     <div class="section-title left-title">
                        <span class="top-title">Find Our Location</span>
                        <h2>Locations Of Our Restaurant All Over The World</h2>
                        <p>On the other hand, we denounce with righteous indignation and dislike men who are mantis
                           beguiled aitem demora lized by the charms of pleasure of the moment.
                        </p>
                     </div>
                     <h3>Where Buy Our Restaurant</h3>
                     <div class="row">
                        <div class="col-lg-4 col-sm-4 col-md-4">
                           <div class="location-list">
                              <ul>
                                 <li>
                                    <i class='bx bx-check'></i>Dummy voluptatem
                                 </li>
                                 <li>
                                    <i class='bx bx-check'></i>Accusantium
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4">
                           <div class="location-list">
                              <ul>
                                 <li>
                                    <i class='bx bx-check'></i>Typesetting
                                 </li>
                                 <li>
                                    <i class='bx bx-check'></i>Popular belief
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4">
                           <div class="location-list">
                              <ul>
                                 <li>
                                    <i class='bx bx-check'></i>Established
                                 </li>
                                 <li>
                                    <i class='bx bx-check'></i>Many variations
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     
                  </div>
               </div>
               <div class="col-lg-6" data-cue="zoomIn" data-duration="2000">
                  <div class="location-map">
                     <img src="<?php echo base_url();?>frontend/images/location-map-img.webp" alt="images">
                     <div class="location-text">
                        <span></span>
                        <p>USA</p>
                     </div>
                     <div class="location-text location-1">
                        <span></span>
                        <p>Peru</p>
                     </div>
                     <div class="location-text location-2">
                        <span></span>
                        <p>Ecuador</p>
                     </div>
                     <div class="location-text location-3">
                        <span></span>
                        <p>Chile</p>
                     </div>
                     <div class="location-text location-4">
                        <span></span>
                        <p>South Africa</p>
                     </div>
                     <div class="location-text location-5">
                        <span></span>
                        <p>United States</p>
                     </div>
                     <div class="location-text location-6">
                        <span></span>
                        <p>Libya</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div> -->
      <div class="footer-widget-area  pt-100 pb-70">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="footer-widget">
                     <a href="<?php echo base_url();?>">
                     <img src="<?php echo base_url();?>frontend/images/logo.png" alt="images" width="100" height="100">
                     </a>
                     <p><?php echo $this->lang->line('33') ?></p>
                     <ul class="footer-widget-list">
                        <li>
                           <a href="https://facebook.com" target="_blank">
                           <i class='bx bxl-facebook'></i>
                           </a>
                        </li>
                        <li>
                           <a href="https://twitter.com" target="_blank">
                           <i class='bx bxl-twitter'></i>
                           </a>
                        </li>
                        <li>
                           <a href="https://linkedin.com" target="_blank">
                           <i class='bx bxl-linkedin'></i>
                           </a>
                        </li>
                        <li>
                           <a href="https://www.instagram.com" target="_blank">
                           <i class='bx bxl-instagram'></i>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="footer-widget">
                     <h2><h2><?php echo $this->lang->line('34') ?></h2></h2>
                     <ul class="footer-list">
                        <li>
                           <i class='bx bxs-downvote'></i><a href="about.php"><?php echo $this->lang->line('40') ?></a>
                        </li>
                        <li>
                           <i class='bx bxs-downvote'></i><a href="menu.php"><?php echo $this->lang->line('41') ?></a>
                        </li>
                        <li>
                           <i class='bx bxs-downvote'></i><a href="booking-table.php"><?php echo $this->lang->line('42') ?></a>
                        </li>
                        <li>
                           <i class='bx bxs-downvote'></i><a href="contact.php"><?php echo $this->lang->line('43') ?></a>
                        </li>
                        <li>
                           <i class='bx bxs-downvote'></i><a href="gallery.php"><?php echo $this->lang->line('44') ?></a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="footer-widget footer-services">
                     <h2><?php echo $this->lang->line('37') ?></h2>
                     <ul class="footer-list">
                        <li>
                           Monday <span>08:00 AM – 05:00 PM</span>
                        </li>
                        <li>
                           Thesday <span>09:00 AM – 06:00 PM</span>
                        </li>
                        <li>
                           Wednesday <span>10:00 AM – 05:00 PM</span>
                        </li>
                        <li>
                           Friday <span>09:00 AM – 05:00 PM</span>
                        </li>
                        <li>
                           Sat - Sun <span>Closed</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                  <div class="footer-widget">
                     <h2><?php echo $this->lang->line('38') ?></h2>
                     <div class="footer-item">
                        <i class='bx bxs-phone-call'></i>
                        <a href="tel:(800)2162020">(800) 216 2020</a>
                     </div>
                     <div class="footer-item">
                        <i class='bx bx-envelope'></i>
                        <a href="mailto:restaurant@gmail.com"><span>Restaurant@gmail.com</span></a>
                     </div>
                     <div class="footer-item">
                        <i class='bx bx-map'></i>
                        <p>No. 12, Ribon Building, US</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="footer-shape-1">
            <img src="<?php echo base_url();?>frontend/images/footer/footer-shape-1.webp" alt="images">
         </div>
         <div class="footer-shape-2">
            <img src="<?php echo base_url();?>frontend/images/footer/footer-shape-2.webp" alt="images">
         </div>
         <div class="footer-shape-3">
            <img src="<?php echo base_url();?>frontend/images/footer/footer-shape-3.webp" alt="images">
         </div>
         <div class="footer-shape-4">
            <img src="<?php echo base_url();?>frontend/images/footer/footer-shape-4.webp" alt="images">
         </div>
      </div>
      <div class="copyright-content">
         <p>© <?php echo date('Y'); ?> Designed & Developed By <a href="https://amoriotech.com/" target="_blank">Amorio Technologies</a></p>
      </div>
      <div class="go-top">
         <i class='bx bxl-upwork'></i>
         <i class='bx bxl-upwork'></i>
      </div>
      <!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"> -->
      <script src="<?php echo base_url();?>frontend/js/jquery.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/meanmenu.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/scrollCue.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/bootstrap-datepicker.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/appear.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/odometer.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/magnific-popup.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/fancybox.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/owl.carousel.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/parallax.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/ajaxchimp.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/form-validator.min.js"></script>
      <script src="<?php echo base_url();?>frontend/js/subscribe-custom.js"></script>
      <script src="<?php echo base_url();?>frontend/js/contact-form-script.js"></script>
      <script src="<?php echo base_url();?>frontend/js/main.js"></script>
   

   <style type="text/css">
      .default-btn{
         padding: 9.5px 15px 9.5px 15px !important;
      }
      .form-control{
        height: 44px;
      }

      .flag_bef::before {
        position: absolute;
        content: '';
        height: 77%;
        width: 100%;
        z-index: -1;
        background-image: url('<?php echo base_url();?>frontend/images/flag.png');
        background-size: cover;
        opacity: 1;
        bottom: 0;
        left: 0; 
     }
     
     @media only screen and (max-width: 767px){
         .logo-light{
             width: 80px !important;
         }
         
     }

   </style>
   
   <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 100%;
  }
  </style>

   <script type="text/javascript">
        var csrfName = '<?php echo $this->security->get_csrf_token_name();?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash();?>';
        $(document).on('click','.add_items',function(){
           $('#insert_data').submit(function (event) {
              var dataString = {
                 dataString : $("#insert_data").serialize()
            };
            dataString[csrfName] = csrfHash;

            $.ajax({
               type:"POST",
               dataType:"json",
               url:"<?php echo base_url(); ?>hotel/insert_items",
               data:$("#insert_data").serialize(),
               success:function(data)
               {     
              
                console.log(data);
               },
               error: function (){ }
            })
           });
        });
        var index = 0;
var slides = document.querySelectorAll(".slides");
var dot = document.querySelectorAll(".dot");

function changeSlide(){

  if(index<0){
    index = slides.length-1;
  }
  
  if(index>slides.length-1){
    index = 0;
  }
  
  for(let i=0;i<slides.length;i++){
    slides[i].style.display = "none";
    dot[i].classList.remove("active");
  }
  
  slides[index].style.display= "block";
  dot[index].classList.add("active");
  
  index++;
  
  setTimeout(changeSlide,2000);
  
}

changeSlide();
    </script>


   </body>
</html>