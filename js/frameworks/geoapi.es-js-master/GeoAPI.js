var GeoAPI = angular.module('GeoAPI', []);

GeoAPI.factory('GeoAPI', function($http, $q){
	var self = this;

	this.conf = {
		url: '//apiv1.geoapi.es/',
		type: 'JSON',
		key: '',
		sandbox: 0
	};

	this._data = {
		lastQuery: {
			url: '',
			params: {}
		},
		lastResult: {
			status: 0,
			data: {}
		}
	};

	return {
		setConfig: function(constant, value){
			self.conf[constant] = value;
		},

		getLastQuery: function(){
			return self._data.lastQuery;
		},

		getLastResult: function(){
			return self._data.lastResult;
		},

		_call: function(accion, params, deferred){
			angular.extend(params, angular.copy(self.conf));
			delete params.url;

			$http({
				method: 'GET',
				url: self.conf.url + accion,
				params: params
			}).then(function(data){

				self._data = {
					lastQuery: {
						url: data.config.url,
						params: data.config.params
					},
					lastResult: {
						status: data.status,
						data: data.data
					}
				};

				if(data.status != 200){
					deferred.reject(data);
					console.log("Error: ", data);
				}else{
					deferred.resolve(data.data);
				}
			});

			return deferred.promise;
		},

		calles: function calles(params){ /*CPRO, CMUM, CUN, CPOS*/
			var deferred = $q.defer();
			return this._call('calles', params, deferred);
		},

		comunidades: function comunidades(params){ /**/
			var deferred = $q.defer();
			return this._call('comunidades', params, deferred);
		},

		cps: function cps(params){ /*CPRO, CMUM, CUN*/
			var deferred = $q.defer();
			return this._call('cps', params, deferred);
		},

		municipios: function municipios(params){ /*CPRO*/
			var deferred = $q.defer();
			return this._call('municipios', params, deferred);
		},

		nucleos: function nucleos(params){ /*CPRO, CMUM, NENTSI50*/
			var deferred = $q.defer();
			return this._call('nucleos', params, deferred);
		},

		poblaciones: function poblaciones(params){ /*CPRO, CMUM*/
			var deferred = $q.defer();
			return this._call('poblaciones', params, deferred);
		},

		provincias: function provincias(params){ /*CCOM*/
			var deferred = $q.defer();
			return this._call('provincias', params, deferred);
		},

		qcalles: function qcalles(params){ /*QUERY*/
			var deferred = $q.defer();
			return this._call('qcalles', params, deferred);
		}
	};
});
