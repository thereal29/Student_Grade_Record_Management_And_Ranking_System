<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Grades</title>
    <!-- Include any necessary stylesheets -->
    <style>
        /* Customize table styles as needed */
        table {
            width: 100%;
            margin-top:80px;
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
        .bold-text{
            display:inline-block;
        }
    
        /* CSS to display h4 elements inline with space between them */
        .bold-text h4 {
            display: block;
            /* Adjust the value as needed */
            font-size: 16px;
            margin: 0;
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
        <h3>Student's Certificate of Grades</h3>
    </div>
    <div class="row"></div>
        <div class="text left">
            <h4>LRN: <small style="text-decoration: underline; font-weight: normal;">{{$student_sel->lrn_number}}</small></h4>
            <h4>Student Name: <small style="text-decoration: underline; font-weight: normal;">{{$student_sel->firstname.' '.$student_sel->lastname}}</small></h4>
        </div>
        <div class="text right" style="right:0;">
            <h4>Grade & Section: <small style="text-decoration: underline; font-weight: normal;">{{$student_sel->grade_level.' - '.$student_sel->section}}</small></h4>
            <h4>School Year: <small style="text-decoration: underline; font-weight: normal;">{{$student_sel->from_year.' - '.$student_sel->to_year}}</small></h4>
        </div>
    </div>
        
    <main>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="4" style="font-size:14px; font-weight:bold; text-align:center;">Quarter</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>Subject</th>
                    <th>Credits</th>
                    <th>Instructor</th>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                    <th>Final</th>				  		
                    <th>Remarks</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->subject_description }}</td>
                    <td>{{ $student->credits }}</td>
                    <td>{{ $student->firstname.' '. $student->lastname }}</td>
                    <td>{{ $student->firstQ }}</td>
                    <td>{{ $student->secondQ }}</td>
                    <td>{{ $student->thirdQ }}</td>
                    <td>{{ $student->fourthQ }}</td>
                    <td>{{ $student->cumulative_gpa }}</td>
                    @if($student->cumulative_gpa < 75)
                    <td style="width: 5%; text-align:center; font-weight:bold; color:red; background-color: #D6EEEE;">FAILED</td>
                    @else
                    <td style="width: 5%; text-align:center; font-weight:bold; color:green; background-color: #D6EEEE;">PASSED</td>
                    @endif
                    <!-- Render other student data -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    {!! $footer !!} <!-- Include the footer -->
</body>
</html>
