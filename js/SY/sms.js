/**
 * SMS
 * 
 * @author Slava Yurthev
 */

if(typeof(sy) == "undefined"){
	var sy = {};
}

if(typeof(sy.sms) == "undefined"){
	sy.sms = {
		ajax:{
			template: {
				url: false
			}
		},
		config: {
			order: {
				id: false
			},
			size: false
		},
		updateLength: function(message, counter, size){
			var length = message.getValue().length;
			counter.select('span').first().update(length);
			counter.select('span').last().update(Math.ceil(length/size));
		},
		setTemplate: function(model, identifier, message){
			if(model == 'sales/order'){
				if(identifier != false && identifier != ''){
					new Ajax.Request(sy.sms.ajax.template.url, {
						parameters: {
							order_id: sy.sms.config.order.id,
							template: identifier
						},
						onComplete: function(response){
							if(response.status == 200){
								message.setValue(response.responseJSON.msg);
								message.dispatchEvent(new Event('change'));
							}
						}
					});
				}
				else{
					message.setValue('');
					message.dispatchEvent(new Event('change'));
				}
			}
		},
		sendSalesOrderSms: function(telephone, message, form){
			if(Validation.validate(telephone) && Validation.validate(message)){
				form.submit();
			}
		}
	}
}