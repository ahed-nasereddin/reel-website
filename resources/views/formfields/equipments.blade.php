<div id="voyager-equipments" v-cloak>
    <div v-for="(item, index) in equipments" :key="index" class="equipment-row">
        <!-- Name -->
        <input type="text"
               class="equipment-input"
               :name="'{{ $row->field }}['+index+'][name]'"
               data-name="Name"
               v-model="item.name"
               placeholder="Name"
               required>

        <!-- Count -->
        <input type="number"
               class="equipment-input count-input"
               :name="'{{ $row->field }}['+index+'][count]'"
               data-name="Count"
               v-model="item.count"
               step="any"
               placeholder="Count"
               required>

        <!-- Note -->
        <input type="text"
               class="equipment-input"
               :name="'{{ $row->field }}['+index+'][note]'"
               data-name="Note"
               v-model="item.note"
               placeholder="Note">

        <!-- Remove button -->
        <button type="button" @click="removeItem(index)" class="remove-btn">X</button>
    </div>

    <button type="button" @click="addItem()" class="add-btn">Add Equipment</button>

    <!-- Hidden input for JSON -->
    <input type="hidden" name="{{ $row->field }}" :value="JSON.stringify(equipments)">
</div>



@php
    $equipmentsValue = $dataTypeContent->{$row->field} ?? null;
    if (is_string($equipmentsValue) && $equipmentsValue !== '') {
        $equipments = json_decode($equipmentsValue, true) ?: [];
    } elseif (is_array($equipmentsValue)) {
        $equipments = $equipmentsValue;
    } else {
        $equipments = [['name' => '', 'count' => 1, 'note' => '']];
    }
@endphp

<script>
document.addEventListener("DOMContentLoaded", function() {
    const el = document.getElementById('voyager-equipments');

    new Vue({
        el,
        data: {
            equipments: {!! json_encode($equipments) !!}
        },
        methods: {
            addItem() {
                this.equipments.push({ name: '', count: 1, note: '' });
            },
            removeItem(index) {
                this.equipments.splice(index, 1);
            }
        },
        mounted() {
            el.closest('form').addEventListener('submit', () => {
                const hidden = el.querySelector('input[type="hidden"]');
                hidden.value = JSON.stringify(this.equipments);
            });
        }
    });
});
</script>


<style>
/* Row container */
.equipment-row {
    display: flex;
    flex-wrap: wrap;       /* wrap inputs on small screens */
    align-items: center;
    gap: 10px;             /* spacing between inputs */
    margin-bottom: 10px;
}

/* All inputs style */
.equipment-input {
    flex: 1 1 200px;       /* flexible, min width 200px */
    padding: 6px 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Count input smaller width */
.count-input {
    flex: 0 0 80px;        /* fixed width */
}

/* Remove button */
.remove-btn {
    flex: 0 0 auto;
    background-color: #e3342f;
    color: #fff;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.remove-btn:hover {
    background-color: #cc1f1a;
}

/* Add button */
.add-btn {
    background-color: #3490dc;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.add-btn:hover {
    background-color: #2779bd;
}

/* Hide Vue content before initialization */
[v-cloak] { display: none; }

/* Responsive adjustments */
@media (max-width: 640px) {
    .equipment-input, .count-input, .remove-btn {
        flex: 1 1 100%;      /* full width on small screens */
    }
    .count-input {
        max-width: 100px;    /* optional: limit width */
    }
}
</style>