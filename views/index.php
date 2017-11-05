<div>
    <ul class="uk-breadcrumb">
        <li class="uk-active"><span>@lang('Detektivo')</span></li>
    </ul>
</div>


<div class="" riot-view>

    <div class="uk-width-medium-1-1 uk-viewport-height-1-3 uk-container-center uk-text-center uk-flex uk-flex-middle uk-flex-center" if="{ !App.Utils.count(collections) }">

        <div class="uk-width-medium-1-3 uk-animation-scale">

            <p>
                <img src="@url('collections:icon.svg')" width="80" height="80" alt="Collections" data-uk-svg />
            </p>
            <hr>
            <span class="uk-text-large uk-text-muted">@lang('No Collections defined').
        </div>

    </div>


    <div class="uk-grid uk-grid-width-medium-1-3" if="{ App.Utils.count(collections) }">

        <div class="uk-grid-margin" each="{ fields, collection in collections }">

            <div class="uk-panel uk-panel-box uk-panel-card">

                <div class="uk-text-bold uk-flex uk-flex-middle">
                    <span class="uk-flex-item-1">{collection}</span>
                    <span class="uk-badge">{ Array.isArray(fields) ? fields.length : 0}</span>
                    <a class="uk-button uk-button-link" onclick="{ parent.reIndex }"><i class="uk-icon-refresh"></i></a>
                </div>


            </div>

        </div>

    </div>


    <script type="view/script">

        var $this = this;

        this.collections = {{ json_encode($collections) }};

        reIndex(e) {

            var collection = e.item.collection;


            App.ui.block('<div class="uk-text-center"><i class="uk-icon-spin uk-icon-spinner uk-text-xlarge uk-text-primary"></i><p class="uk-text-large uk-text-bold">Re-Indexing '+collection+'</p><div class="uk-margin uk-text-muted">This may take a while</div></div>');

            App.request('/detektivo/reindex', {collection: collection}).then(function() {
                App.ui.unblock();
            });
        }

    </script>

</div>
