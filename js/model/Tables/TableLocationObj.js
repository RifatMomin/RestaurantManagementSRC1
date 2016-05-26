/**
 * @description This is the Table Location object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableLocationObj = function () {
    this.location_id = null;
    this.name_location = null;

    this.construct = function(location_id, name_location){
        this.setLocationId(location_id);
        this.setNameLocation(name_location);
    };
    
    this.setLocationId = function(location_id){
        this.location_id = location_id;
    }
    
    this.getLocationId = function (){
        return this.location_id;
    }
    
    this.setNameLocation = function (name_location){
        this.name_location = name_location;
    }
    this.getNameLocation = function (){
        return this.name_location;
    }


};