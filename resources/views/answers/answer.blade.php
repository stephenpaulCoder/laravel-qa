<answer-component :answer="{{ $answer }}" inline-template>
    <div class="media post">
        @include('shared.vote',[ 'model'=>$answer ])
        <div class="media-body">
            <!-- {!! $answer->body !!} -->
            <form v-if="editing">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button type="button" v-on:click="update" class="btn btn-primary btn-sm" :disabled="isInvalid">
                    Update
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" @click="cancel">
                    Cancel
                </button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can ('update', $answer)
                            <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            @endcan @can ('delete', $answer)
                            <button type="button" v-on:click="destroy" class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4 mt-4">
                        <!-- @include('shared.author',[ 'model'=>$answer, 'label'=>'answered' ])  vue component below-->
                        <author-component :model="{{ $answer }}" label="Answered">
                        </author-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer-component>
