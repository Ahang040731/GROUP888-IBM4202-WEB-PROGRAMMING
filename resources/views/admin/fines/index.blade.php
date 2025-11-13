@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bh-container">
    <h1 class="bh-h1">Admin Fines</h1>

    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-top: 20px;">
        <thead>
            <tr style="background-color: #4F46E5; color: white; text-align: left;">
                <th style="padding: 12px; border: 1px solid #ddd;">Item</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Count</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 12px; border: 1px solid #ddd;">Users</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ $users }}</td>
            </tr>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;">Books</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ $books }}</td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 12px; border: 1px solid #ddd;">Borrowings</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ $borrowings }}</td>
            </tr>
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;">Fines</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">{{ $fines }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection