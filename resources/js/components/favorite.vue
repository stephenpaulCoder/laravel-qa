<template>
    <div>
        <a title="Click to mark as favorite question (Click again to undo)" :class="classes" @click.prevent="toggle">
            <i class="fas fa-star fa-2x"></i>
            <span class="favorites-count">{{count }}</span>
        </a>
    </div>
</template>
<script>
export default {
    props: ['question'],
    data() {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
            signedIn: true
        }
    },
    computed: {
        classes() {
            return [
                'mt-2',
                'favorite',
                !this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
            ];
        }
    },
    methods: {
        toggle() {
            this.isFavorited ? this.destroy() : this.create();
        },
        destroy() {
            this.count--;
            this.isFavorited = false;
        },
        create() {
            this.count++;
            this.isFavorited = true;
        }

    }
}

</script>
