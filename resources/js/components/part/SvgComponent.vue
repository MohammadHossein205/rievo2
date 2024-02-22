<script setup>
defineProps(['name', 'size', 'color'])

</script>


<template>
    <svg class="icon" :style="{width : `${size}rem` , height : `${size}rem`,fill: `${color}`}" >
        <use :xlink:href="`#${name}`"></use>
    </svg>
</template>

