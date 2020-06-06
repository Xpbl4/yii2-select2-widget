$.fn.select2.amd.require(
	['select2/selection/base', 'select2/selection/search', 'select2/utils'],
	function (BaseSelection, Search, Utils) {

		Search.prototype.resizeSearch = function () {
			this.$search.css('width', '25px');

			var width = this.options.get('width');

			if (!width.length) {
				if (this.$search.attr('placeholder') !== '') {
					width = this.$selection.find('.select2-selection__rendered').innerWidth() || '100%';
				} else {
					var minimumWidth = this.$search.val().length + 1;

					width = (minimumWidth * 0.75) + 'em';
				}
			}

			this.$search.css('width', width);
		};

		BaseSelection.prototype.render = function () {
			var $selection = $(
				'<span class="select2-selection" role="combobox" ' +
				' aria-haspopup="true" aria-expanded="false">' +
				'</span>'
			);

			this._tabindex = 0;

			if (Utils.GetData(this.$element[0], 'old-tabindex') != null) {
				this._tabindex = Utils.GetData(this.$element[0], 'old-tabindex');
			} else if (this.$element.attr('tabindex') != null) {
				this._tabindex = this.$element.attr('tabindex');
			}

			console.log(this.$element.attr('class'));
			if (this.$element.attr('class') != null) {
				var className = this.$element.attr('class');
				$selection.addClass(className);
			}

			$selection.attr('title', this.$element.attr('title'));
			$selection.attr('tabindex', this._tabindex);
			$selection.attr('aria-disabled', 'false');

			this.$selection = $selection;

			return $selection;
		};
	});