@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Leads Count by State</h4>

    <div class="form-group">
        <label for="state">State</label>
        <select class="form-control" id="state" name="state" onchange="fetchLeadsCount(this.value)">
            <option value="">Select State</option>
            @foreach($states as $state)
                <option value="{{ $state->state_id }}">{{ $state->state_name }}</option> 
            @endforeach
        </select>
    </div>

    <table class="table" id="leadsCountTable" style="display: none;">
        <thead>
            <tr>
                <th>State</th>
                <th>Leads Count</th>
            </tr>
        </thead>
        <tbody id="leadsCountBody">  
            <!-- Leads count data will be inserted here dynamically -->
        </tbody>
    </table>
</div>

<script>
    function fetchLeadsCount(stateId) {
        if (stateId) {
            fetch(`/leads_count{$stateId}${stateId}`)
                .then(response => response.json())
                .then(data => {
                    const leadsCountBody = document.getElementById('leadsCountBody');
                    leadsCountBody.innerHTML = ''; // Clear previous data

                    if (data.length > 0) {
                        const leadsCountTable = document.getElementById('leadsCountTable');
                        leadsCountTable.style.display = 'block';

                        data.forEach(lead => {
                            leadsCountBody.innerHTML += `
                                <tr>
                                    <td>${lead.state}</td>
                                    <td>${lead.count}</td>
                                </tr> 
                            `;
                        });
                    } else { 
                        // Handle case where no leads are found for the selected state
                        leadsCountBody.innerHTML = `
                            <tr>
                                <td colspan="2">No leads found for the selected state.</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => console.error('Error fetching leads count:', error));
        } else {
            // Handle case where no state is selected
            const leadsCountTable = document.getElementById('leadsCountTable');
            leadsCountTable.style.display = 'none';
        }
    }
</script>
@endsection
