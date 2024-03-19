<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Header</title>
    <style>
        /* Customize header styles as needed */
        
        .header {
            border-bottom: 1px solid #00330b;
            text-align: center; /* Border at the bottom */
            /* Optional: Add padding at the bottom for spacing */
        }
        .header img {
            width: 200px; /* Adjust size as needed */
            height: auto;
        }
        .header-text{
            position: absolute;
            top: -10px;
            right: 0px;
            display:block;
            
        }
        .header h4 {
        margin: 0; /* Adjust the spacing between the h3 elements */
    }
    .header small {
        display:block;
        margin: 0; /* Adjust the spacing between the h3 elements */
    }
    
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/img/header.jpg') }}" alt="Dashboard Icon">
        <div class="header-text">
            <h4>VSU INTEGRATED HIGH</h4>
            <h4>SCHOOL</h4>
            <small style="font-size:10px;">Visca, Baybay City, Leyte, 6521-A</small>
            <small style="font-size:10px;">Tel: 565-0600 loc. 1074 (JHS); 1075 (SHS)</small>
            <small style="font-size:10px;">Email: jhs@vsu.edu.ph /integrated.hs@vsu.edu.ph</small>
            <small style="font-size:10px;">Website: www.vsu.edu.ph</small>
        </div>
</div>
    
</body>
</html>