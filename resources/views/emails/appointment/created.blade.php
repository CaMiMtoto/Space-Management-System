<x-mail::message>
Dear {{ $appointmentBooking->name }},

Your appointment has been created successfully.

Here are your appointment details: <br/>
<strong>Guest Phone Number:</strong> {{ $appointmentBooking->phone }} <br/>
<strong>Guest Email:</strong> {{ $appointmentBooking->email }} <br/>
<strong>Guest Address:</strong> {{ $appointmentBooking->address }} <br/>
<strong>Appointment Start Date:</strong> {{ $appointmentBooking->start_date_time->format('F d, Y') }} <br/>
<strong>Appointment End Date:</strong> {{ $appointmentBooking->end_date_time->format('F d, Y') }} <br/>

You will receive an email regarding the status of your appointment.

If you have any questions, feel free to contact us.

Thank you for booking!

{{ config('app.name') }}
</x-mail::message>
