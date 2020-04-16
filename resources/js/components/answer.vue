<script>
export default {
    props: ["answer"],
    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            // to hold answer id
            id: this.answer.id,
            // //question id to hold question id of the answer
            questionId: this.answer.question_id,
            //
            beforeEditCache: null
        };
    },
    methods: {
        // edit method before editing store the old body to beforeEditCache
        edit() {
            this.beforeEditCache = this.body;
            this.editing = true;
        },
        //restore the body property with old body that store in beforeEditCache
        cancel() {
            this.body = this.beforeEditCache;
            this.editing = false;
        },
        //questions/{question}/answers/{answer} change the {question} to this.questionId questionId that holds the current question
        // change the {answer} to this.id  answerid that holds the current question
        update() {
            axios
                .patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                })
                .then(res => {
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    // alert(res.data.message);
                })
                .catch(err => {
                    alert(err.response.data.message);
                });
        }
    },
    computed: {
        //invalid if the form is empty or less than 10 char
        isInvalid() {
            this.body.length < 10;
        }
    }
};
</script>
