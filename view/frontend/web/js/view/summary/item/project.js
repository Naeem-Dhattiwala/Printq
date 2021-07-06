define(
	[
		'uiComponent'
	],
	function (Component) {
		"use strict";
		var quoteItemData = window.checkoutConfig.quoteItemData;
		return Component.extend({
			defaults: {
				template: 'Printq_NewColumnCartPage/summary/item/project'
			},
			quoteItemData: quoteItemData,
			getValue: function(quoteItem) {
				return quoteItem.name;
			},
			getProject: function(quoteItem) {
                var item = this.getItem(quoteItem.item_id);
                if (item.project) {
                	return 'Project Name : '+item.project;
                }else{
                	return;
                }
                
            },
			getItem: function(item_id) {
				var itemElement = null;
				_.each(this.quoteItemData, function(element, index) {
					if (element.item_id == item_id) {
						itemElement = element;
					}
				});
				return itemElement;
			}
		});
	}
);