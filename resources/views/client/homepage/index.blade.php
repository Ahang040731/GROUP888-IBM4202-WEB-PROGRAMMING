@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

  <!-- I DONT KNOW WHY THIS SHIT CALL DASHBOARD YOUR TASK SHOULD BE USER SIDE HOMEPAGE by heng-->
  <!-- DASHBOARD should be done by yongjie Admin side -->




  <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

  <div class="grid md:grid-cols-3 gap-4">
    <div class="bg-white border rounded-lg p-4">
      <p class="text-sm text-gray-500">Total Books</p>
      <p class="text-3xl font-semibold">{{ $stats['books'] ?? 0 }}</p>
    </div>
    <div class="bg-white border rounded-lg p-4">
      <p class="text-sm text-gray-500">Active Members</p>
      <p class="text-3xl font-semibold">{{ $stats['members'] ?? 0 }}</p>
    </div>
    <div class="bg-white border rounded-lg p-4">
      <p class="text-sm text-gray-500">Books on Loan</p>
      <p class="text-3xl font-semibold">{{ $stats['loans'] ?? 0 }}</p>
    </div>
  </div>

  <div class="mt-6 bg-white border rounded-lg p-4">
    <h2 class="font-semibold mb-2">Recent Activity</h2>
    <ul class="list-disc pl-5 text-sm text-gray-700">
      <li>Issued “Clean Code” to Member #1032</li>
      <li>Returned “Design Patterns”</li>
      <li>Added 5 new books to “Data Science”</li>
    </ul>
  </div>
@endsection
