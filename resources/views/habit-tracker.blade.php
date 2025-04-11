<div class="container mt-3">
    <h5 class="fw-bold ms-2">Activity Tracker</h5>
    <small class="text-muted ms-2 mb-3 d-block">All View</small>

    @if($habits->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle-fill"></i> No habits found for this day.
        </div>
    @else
        <div class="habit-list">
            @foreach(['Family', 'Health', 'Money', 'Self Care', 'Home Care', 'Goals', 'Time'] as $category)
                @php
                    $filteredHabits = $habits->where('category', $category);
                    $iconEmoji = match($category) {
                        'Family' => '🧑‍🤝‍🧑',
                        'Health' => '🫀',
                        'Money' => '💰',
                        'Self Care' => '😊',
                        'Home Care' => '🧼',
                        'Goals' => '🎯',
                        'Time' => '⏰',
                        default => '📌'
                    };
                @endphp
                <div class="rounded-pill-row">
                    <div class="category-title d-flex align-items-center justify-content-between" onclick="toggleCollapse('{{ Str::slug($category) }}')">
                        <div class="d-flex align-items-center">
                            <span class="emoji me-2">{{ $iconEmoji }}</span>    
                            <span class="fw-semibold">{{ $category }}</span>
                        </div>
                        <i class="bi bi-chevron-down" id="icon-{{ Str::slug($category) }}"></i>
                    </div>
                    <div id="collapse{{ Str::slug($category) }}" class="collapse">
                        <ul class="dots-row">
                        @if($filteredHabits->isEmpty())
                            <li class="">No habits in this category</li>
                        @else
                            @foreach($filteredHabits as $habit)
                                <li class=" dot filled" >{{ $habit->name }} | {{ date('g:i A', strtotime($habit->start_time)) }} - {{ date('g:i A', strtotime($habit->end_time)) }}</li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function toggleCollapse(id) {
        const target = document.getElementById('collapse' + id);
        const icon = document.getElementById('icon-' + id);
        const isOpen = target.classList.contains('show');

        document.querySelectorAll('.collapse').forEach(el => el.classList.remove('show'));
        document.querySelectorAll('.bi-chevron-up, .bi-chevron-down').forEach(el => el.classList.replace('bi-chevron-up', 'bi-chevron-down'));

        if (!isOpen) {
            target.classList.add('show');
            icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
        }
    }
</script>

<style>
.container {
    border-radius: 25px;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

.habit-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.rounded-pill-row {
    background-color: #fafafa;
    border-radius: 20px;
    padding: 12px 15px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
    cursor: pointer;
    border: 1px solid #e0e0e0;
}

.category-title {
    font-size: 1rem;
    display: flex;
    align-items: center;
    font-weight: 600;
    color: #333;
    justify-content: space-between;

}

.emoji {
    font-size: 1.4rem;
}

.dots-row {
    display: flex;
    flex-direction: column; 
    gap: 8px;
    padding: 10px 0 0 10px;
    margin: 0;
    list-style: none;
}

.dot {
    background-color: transparent; 
    color: #333;
    font-size: 0.95rem;
    position: relative;
    padding-left: 20px;
}

.dot::before {
    content: '●';
    color: #198754;
    position: absolute;
    left: 0;
    top: 0;
    font-size: 1rem;
    line-height: 1.2;
}


/* .dot.filled {
    background-color: #198754;
} */


.collapse {
    display: none;
}

.collapse.show {
    display: flex;
    flex-direction: column;
}

h5.fw-bold {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

small.text-muted {
    font-size: 0.9rem;
    margin-bottom: 15px;
    display: block;
}

.bi {
    font-size: 1rem;
    color: #888;
}
</style>

@include('components.layouts.footer')
