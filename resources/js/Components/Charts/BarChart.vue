<template>
    <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
    chartData: Object,
});

const chartCanvas = ref(null);
let chartInstance = null;

onMounted(() => {
    if (chartCanvas.value) {
        chartInstance = new Chart(chartCanvas.value, {
            type: 'bar',
            data: props.chartData,
        });
    }
});

watch(() => props.chartData, (newData) => {
    if (chartInstance) {
        chartInstance.data = newData;
        chartInstance.update();
    }
});
</script>
