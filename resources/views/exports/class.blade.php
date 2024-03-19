<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLASS_ROSTER</title>
    <style>
        /* Customize header styles as needed */
        
        .header {
            border-bottom: 1px solid #00330b;
            text-align: center; /* Border at the bottom */
            /* Optional: Add padding at the bottom for spacing */
        }
    
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h4></h4>
            <h4>VSU INTEGRATED HIGH SCHOOL</h4>
            <h4>Student Grade Record Management And Ranking System Generated Excel File</h4>
            <h4></h4>
            <h4>CLASS ROSTER</h4>
            <h4>{{$class_sel->from_year.' - '.$class_sel->to_year}}</h4>
            <h4>Faculty Name: {{$class_sel->firstname.' '.$class_sel->lastname}}</h4>
            <h3>Subject Name: {{$class_sel->subject_code.' | '.$class_sel->subject_description}}</h3>
            <h4></h4>
        </div>
</div>
<table>
    <thead>
        <tr>
            <th style="font-weight:bold;">No.</th>
            <th style="font-weight:bold;">LRN NUMBER</th>
            <th style="font-weight:bold;">FULL NAME</th>
            <th style="font-weight:bold;">GENDER</th>
            <th style="font-weight:bold;">GRADE LEVEL AND SECTION</th>
            <th style="font-weight:bold;">EMAIL</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $key => $class)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $class->lrn_number }}</td>
            <td>{{ strtoupper($class->lastname.', '.$class->firstname) }}</td>
            <td>{{ $class->gender }}</td>
            <td>{{ $class->grade_level.' '.$class->section }}</td>
            <td>{{ $class->email }}</td>
            <!-- Render other student data -->
        </tr>
        @endforeach
    </tbody>
</table>
    
</body>
</html>

