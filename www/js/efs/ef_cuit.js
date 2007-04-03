ef_cuit.prototype = new ef();
ef_cuit.prototype.constructor = ef_cuit;

	/**
	 * @class Triple editbox que constituyen las 3 partes del CUIT/CUIL
	 * @constructor
	 * @phpdoc Componentes/Efs/toba_ef_cuit toba_ef_cuit
	 */
	function ef_cuit(id_form, etiqueta, obligatorio, colapsado) {
		ef.prototype.constructor.call(this, id_form, etiqueta, obligatorio, colapsado);
	}

	ef_cuit.prototype.input = function(posicion) {
		return document.getElementById(this._id_form + '_' + posicion);
	};
	
	ef_cuit.prototype.validar = function () {
		var valor = this.get_estado();
		if (this._obligatorio && ereg_nulo.test(valor)) {
			this._error = ' es obligatorio.';
		    return false;
		}
		if (isNaN(valor)) {
			this._error = ' tiene que ser num�rico.';
		    return false;
		}
		if (valor !== '' && ! es_cuit(valor)) {
			this._error = ' no es una clave v�lida.';
		    return false;			
		}
		return true;
	};	
	
	/**
	 * Retorna el cuit/cuil actual como un unico string, sin caracteres intermedio
	 * Por ejemplo 20271957786
	 * @type string
	 */
	ef_cuit.prototype.get_estado = function() {
		var estado = 	this.input(1).value.pad(2, '0', "PAD_LEFT") + 
						this.input(2).value.pad(8, '0',"PAD_LEFT") + 
						this.input(3).value;
		if (estado === '0000000000') {
			return '';	
		}
		return estado;
	};	
	
	ef.prototype.get_tab_index = function () {
		return this.input(1).tabIndex;
	};	
	
	ef.prototype.set_tab_index = function(tab_index) {
		this.input(1).tabIndex = tab_index;
		this.input(2).tabIndex = tab_index;
		this.input(3).tabIndex = tab_index;
	};
	
	
	ef_cuit.prototype.set_estado = function(nuevo,posicion) {
		this.input(posicion).value = nuevo;
		if (this.input(posicion).onblur) {
			this.input(posicion).onblur();
		}
	};	
	
	//cuando_cambia_valor (disparar_callback)
	ef_cuit.prototype.cuando_cambia_valor = function(callback) { 
		addEvent(this.input(1), 'onblur', callback);
		addEvent(this.input(2), 'onblur', callback);
		addEvent(this.input(3), 'onblur', callback);
	};
	
	ef_cuit.prototype.set_solo_lectura = function(solo_lectura) {
		for (var i=1 ; i<4; i++) {
			this.input(i).readOnly = (typeof solo_lectura == 'undefined' || solo_lectura);
		}
	};		

function es_cuit(nro) {
	var suma;
	var resto;
	var verif;
	var pos = nro.split('');
	if (! (/^\d{11}$/).test(nro)) {
		return false;
	}
	
	while (true) {
		suma = (pos[0] * 5 + pos[1] * 4 + pos[2] * 3 +
			pos[3] * 2 + pos[4] * 7 + pos[5] * 6 +
			pos[6] * 5 + pos[7] * 4 + pos[8] * 3 + pos[9] * 2);
		resto = suma % 11;
		if (resto === 0) {
			verif = 0;
			break;
		} 
		else if (resto == 1 && (pos[1] === 0 || pos[6] == 7)) {
			pos[1] = 4;
			continue;
		} else {
			verif = 11 - resto;
			break;
		}
	}
	return pos[10] == verif;
}	
		
toba.confirmar_inclusion('interface/ef_cuit');
