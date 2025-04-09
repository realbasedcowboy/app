<template>
    <div class="coin-flip-container">
        <div class="coin" :class="{ spin: isSpinning }" :style="coinStyle" @animationend="handleAnimationEnd">
            <div class="coin-face heads">Heads</div>
            <div class="coin-face tails">Tails</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import confetti from 'canvas-confetti';
import { computed, onMounted, ref } from 'vue';

const emit = defineEmits<{
    (e: 'flip-ended', result: string): void;
}>();

const props = defineProps({
    result: {
        type: String,
        required: true,
        validator: (value) => ['heads', 'tails'].includes(value),
    },
    choice: {
        type: String,
        required: true,
        validator: (value) => ['heads', 'tails'].includes(value),
    },
});

const isSpinning = ref(false);
const finalRotation = ref(0);

const coinStyle = computed(() => ({
    '--final-rotation': `${finalRotation.value}deg`,
    transform: isSpinning.value ? 'rotateY(0deg)' : `rotateY(${finalRotation.value}deg)`,
}));

const startFlip = () => {
    isSpinning.value = true;
    const baseRotation = props.result === 'heads' ? 0 : 180;
    finalRotation.value = 360 * 3 + baseRotation;
};

const shootConfetti = () => {
    if (props.result === props.choice) {
        confetti({
            particleCount: 100,
            spread: 70,
            origin: { y: 0.6 },
        });
    }
};

const handleAnimationEnd = () => {
    isSpinning.value = false;

    shootConfetti(); // Trigger confetti when animation ends

    emit('flip-ended', props.result);
};

onMounted(() => {
    startFlip();
});
</script>

<style scoped>
.coin-flip-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
    position: relative;
    overflow: hidden;
}

.coin {
    position: relative;
    width: 100px;
    height: 100px;
    transform-style: preserve-3d;
    transition: transform 0.3s ease-out;
}

.spin {
    animation: spin 2s ease-out forwards;
}

.coin-face {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    backface-visibility: hidden;
    font-weight: bold;
}

.heads {
    background-color: #ffd700;
    transform: rotateY(0deg);
}

.tails {
    background-color: #c0c0c0;
    transform: rotateY(180deg);
}

@keyframes spin {
    0% {
        transform: rotateY(0deg);
    }
    100% {
        transform: rotateY(var(--final-rotation));
    }
}
</style>
