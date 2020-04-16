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
                .patch(this.endpoint, {
                    body: this.body
                })
                .then(res => {
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    // alert(res.data.message);
                    //toast the message using iziToast
                    this.$toast.success(res.data.message, "Success", {
                        timeout: 3000
                    });
                })
                .catch(err => {
                    //toast the message using iziToast
                    this.$toast.error(err.response.data.message, "Error", {
                        timeout: 3000
                    });
                });
        },
        //delete for answer.blade.php
        destroy() {
            //change the iziToast to this.$toast
            this.$toast.question("Are you sure about that ?", "Confirm", {
                timeout: 20000,
                close: false,
                overlay: true,
                displayMode: "once",
                id: "question",
                zindex: 999,
                title: "Hey",
                position: "center",
                buttons: [
                    [
                        "<button><b>YES</b></button>",
                        (instance, toast) => {
                            axios.delete(this.endpoint).then(res => {
                                $(this.$el).fadeOut(500, () => {
                                    this.$toast.success(
                                        res.data.message,
                                        "Success",
                                        {
                                            timeout: 3000
                                        }
                                    );
                                });
                            });
                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                        },
                        true
                    ],
                    [
                        "<button>NO</button>",
                        function(instance, toast) {
                            instance.hide(
                                { transitionOut: "fadeOut" },
                                toast,
                                "button"
                            );
                        }
                    ]
                ]
                // onClosing: function(instance, toast, closedBy) {
                //     console.info("Closing | closedBy: " + closedBy);
                // },
                // onClosed: function(instance, toast, closedBy) {
                //     console.info("Closed | closedBy: " + closedBy);
                // }
            });
        }
    },
    computed: {
        //invalid if the form is empty or less than 10 char
        isInvalid() {
            this.body.length < 10;
        },
        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`;
        }
    }
};
</script>
