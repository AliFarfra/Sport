@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Make a Payment for {{ $user->name }}</h1>

    <form action="{{ route('adherents.storePayment') }}" method="POST">
        @csrf

        <input type="hidden" name="adherent_id" value="{{ $user->adherent->id }}">
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="form-group">
            <label for="pack_id">Select Pack</label>
            <select name="pack_id" id="pack_id" class="form-control" required>
                <option value="">Select a pack</option>
                @foreach ($packs as $pack)
                    <option value="{{ $pack->id }}" data-price="{{ $pack->prix }}">{{ $pack->nom }} - {{ $pack->prix }} MAD</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cours_id">Select Courses (optional)</label>
            <select name="cours_id[]" id="cours_id" class="form-control" multiple>
                @foreach ($cours as $coursItem)
                    <option value="{{ $coursItem->id }}" data-price="{{ $coursItem->prix }}">{{ $coursItem->nom }} - {{ $coursItem->prix }} MAD</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="types_de_paiment">Payment Type</label>
            <select name="types_de_paiment" id="types_de_paiment" class="form-control" required>
                <option value="cache">Cash</option>
                <option value="virement">Wire Transfer</option>
                <option value="carte_bancaire">Credit Card</option>
            </select>
        </div>

        <div id="totalAmount" style="margin-top: 10px; font-weight: bold;">Total Amount: 0 MAD</div>

        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packSelect = document.getElementById('pack_id');
    const coursSelect = document.getElementById('cours_id');
    const totalDisplay = document.getElementById('totalAmount');

    function calculateTotal() {
        let total = 0;

        // Add pack amount
        const selectedPack = packSelect.options[packSelect.selectedIndex];
        if (selectedPack && selectedPack.value) {
            total += parseFloat(selectedPack.dataset.price);
        }

        // Add selected courses' amounts
        Array.from(coursSelect.selectedOptions).forEach(option => {
            total += parseFloat(option.dataset.price);
        });

        totalDisplay.textContent = 'Total Amount: ' + total.toFixed(2) + ' MAD';
    }

    packSelect.addEventListener('change', calculateTotal);
    coursSelect.addEventListener('change', calculateTotal);
});
</script>
@endsection