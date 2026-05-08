@extends('layouts.app')
@section('title', 'Privacy Notice')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Privacy Notice</h1>
        <p class="text-gray-600">PDPA Data Management System</p>
    </div>

    <div class="prose prose-sm max-w-none space-y-6">
        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
            <p class="text-gray-700">This Privacy Notice explains how we collect, use, and protect your personal data in accordance with the Personal Data Protection Act (PDPA).</p>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Data Collection</h2>
            <p class="text-gray-700">We collect personal data only for specified, explicit, and legitimate purposes. All data collection is conducted transparently with your knowledge and consent.</p>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Your Rights</h2>
            <p class="text-gray-700 mb-4">You have the right to:</p>
            <ul class="list-disc list-inside text-gray-700 space-y-2">
                <li>Access your personal data</li>
                <li>Request correction of inaccurate data</li>
                <li>Request deletion of your data</li>
                <li>Request portability of your data</li>
                <li>Object to processing</li>
                <li>Restrict processing</li>
            </ul>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Data Retention</h2>
            <p class="text-gray-700">Your personal data is retained only for as long as necessary to fulfill the purposes for which it was collected, unless a longer retention period is required by law.</p>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Data Security</h2>
            <p class="text-gray-700">We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction.</p>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Contact Us</h2>
            <p class="text-gray-700">For questions regarding this privacy notice or your personal data, please contact us.</p>
        </section>
    </div>
</div>
@endsection
