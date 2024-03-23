<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Data</title>
    <link rel="shortcut icon" href="{{ URL::to('assets/img/favicon.png') }}">
    <!-- Include any necessary stylesheets -->
    <style>
        /* Customize table styles as needed */
        table {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
            border-top: 1px solid #dddddd;
            border-bottom: 1px solid #dddddd;
        }
        th, td {
            text-align: left;
            padding: 8px;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;   
        }
        .row {
            width: 100%;
        
        /* Or adjust the height as needed */
        }
        .text {
            position: absolute;
            width: 50%;
            font-size: 16px;
        }

        .left {
        left: 0;
        }

        .right {
        right: 0;
        }
        .left h4 {
                display:block;
                margin: 5px; /* Adjust the spacing between the h3 elements */
        }
        .right h4 {
                display:block;
                margin: 5px; /* Adjust the spacing between the h3 elements */
        }
        
        .bold-text {
            text-align: center;
        }
        
        /* CSS to display h4 elements inline with space between them */
        .bold-text h4 {
            display: inline;
            /* Adjust the value as needed */
            font-size: 18px;
        }
        .data-name {
            background-color: #05300e;
            color: #fff;
            opacity: 60%;
            text-align: center;
            margin-bottom: 20px;
            margin-top:20px;
        }
    </style>
</head>
<body>
    {!! $header !!} <!-- Include the header -->
    <div class="data-name">
        <h3>Class Data</h3>
    </div>
    <div class="row">
        <div class="text left">
            <h4>Instructor: <small style="text-decoration: underline; font-weight: normal;">{{$classes_sel->firstname.' '.$classes_sel->lastname}}</small></h4>
        </div>
        <div class="text right">
            <h4 style="margin-left: 30px;">Subject: <small style="text-decoration: underline; font-weight: normal;">{{$classes_sel->subject_code.' | '.$classes_sel->subject_description}}</small></h4>
        </div>
    </div>
        
    <main>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>LRN Number</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Grade Level & Section</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $key => $class)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $class->lrn_number }}</td>
                    <td>{{ $class->firstname.' '.$class->lastname }}</td>
                    <td>{{ $class->gender }}</td>
                    <td>{{ $class->grade_level.' '.$class->section }}</td>
                    <!-- Render other student data -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    {!! $footer !!} <!-- Include the footer -->
</body>
</html>
