// Toggle element visibility
function toggler(divId) {
    $("#" + divId).toggle();
}

// Change element background color
function setActive(id)
{
    $("#" + id).toggle();

    if ($("#search").hasClass("menu-item-active")) {
        $("#search").removeClass("menu-item-active");
    } else {
        $("#search").addClass("menu-item-active");
    }
}

$(document).ready(function () {

    var catBreeds = [
        {display: "All", value: ""},
        {display: "Mixed", value: "Mixed"},
        {display: "Abyssinian", value: "Abyssinian"},
        {display: "American Bobtail", value: "American Bobtail"},
        {display: "American Curl", value: "American Curl"},
        {display: "American Shorthair", value: "American Shorthair"},
        {display: "American Wirehair", value: "American Wirehair"},
        {display: "Balinese", value: "Balinese"},
        {display: "Bengal", value: "Bengal"},
        {display: "Birman", value: "Birman"},
        {display: "Bombay", value: "Bombay"},
        {display: "British Shorthair", value: "British Shorthair"},
        {display: "Burmese", value: "Burmese"},
        {display: "Chartreux", value: "Chartreux"},
        {display: "Colorpoint Shorthair", value: "Colorpoint Shorthair"},
        {display: "Cornish Rex", value: "Cornish Rex"},
        {display: "Devon Rex", value: "Devon Rex"},
        {display: "Egyptian Mau", value: "Egyptian Mau"},
        {display: "Exotic Shorthair", value: "Exotic Shorthair"},
        {display: "Havana Brown", value: "Havana Brown"},
        {display: "Himalayan", value: "Himalayan"},
        {display: "Japanese Bobtail", value: "Japanese Bobtail"},
        {display: "Javanese", value: "Javanese"},
        {display: "Korat", value: "Korat"},
        {display: "Maine Coon", value: "Maine Coon"},
        {display: "Manx", value: "Manx"},
        {display: "Munchkin", value: "Munchkin"},
        {display: "Nebelung", value: "Nebelung"},
        {display: "Norwegian Forest Cat", value: "Norwegian Forest Cat"},
        {display: "Ocicat", value: "Ocicat"},
        {display: "Oriental", value: "Oriental"},
        {display: "Persian", value: "Persian"},
        {display: "Peterbald", value: "Peterbald"},
        {display: "Pixie-Bob", value: "Pixie-Bob"},
        {display: "Ragdoll", value: "Ragdoll"},
        {display: "Russian Blue", value: "Russian Blue"},
        {display: "Savannah", value: "Savannah"},
        {display: "Scottish Fold", value: "Scottish Fold"},
        {display: "Selkirk Rex", value: "Selkirk Rex"},
        {display: "Siamese", value: "Siamese"},
        {display: "Siberian", value: "Siberian"},
        {display: "Singapura", value: "Singapura"},
        {display: "Snowshoe", value: "Snowshoe"},
        {display: "Somali", value: "Somali"},
        {display: "Sphynx", value: "Sphynx"},
        {display: "Tonkinese", value: "Tonkinese"},
        {display: "Toyger", value: "Toyger"},
        {display: "Turkish Angora", value: "Turkish Angora"},
        {display: "Turkish Van", value: "Turkish Van"}];

    var dogBreeds = [
        {display: "All", value: ""},
        {display: "Mixed", value: "Mixed"},
        {display: "Afghan Hound", value: "Afghan Hound"},
        {display: "Airedale Terrier", value: "Airedale Terrier"},
        {display: "American Eskimo", value: "American Eskimo"},
        {display: "American Pitbull", value: "American Pitbull"},
        {display: "Australian Cattle Dog", value: "Australian Cattle Dog"},
        {display: "Australian Terrier", value: "Australian Terrier"},
        {display: "Bearded Collie", value: "Bearded Collie"},
        {display: "Belgian Malinois", value: "Belgian Malinois"},
        {display: "Belgian Sheepdog", value: "Belgian Sheepdog"},
        {display: "Berger Picard", value: "Berger Picard"},
        {display: "Black Russian Terrier", value: "Black Russian Terrier"},
        {display: "Bloodhound", value: "Bloodhound"},
        {display: "Boxer", value: "Boxer"},
        {display: "Bulldog", value: "Bulldog"},
        {display: "Canaan", value: "Canaan"},
        {display: "Chihuahua", value: "Chihuahua"},
        {display: "Chinook", value: "Chinook"},
        {display: "Chow Chow", value: "Chow Chow"},
        {display: "Collie", value: "Collie"},
        {display: "Dalmation", value: "Dalmation"},
        {display: "Doberman Pinscher", value: "Doberman Pinscher"},
        {display: "Dutch Shepherd", value: "Dutch Shepherd"},
        {display: "English Setter", value: "English Setter"},
        {display: "Pug", value: "Pug"},
        {display: "Labrador Retriever", value: "Labrador Retriever"},
        {display: "Golden Retriever", value: "Golden Retriever"},
        {display: "German Shephered", value: "German Shephered"},
        {display: "Yorkshire Terrier", value: "Yorkshire Terrier"},
        {display: "Poodle", value: "Poodle"},
        {display: "Pomeranian", value: "Pomeranian"},
        {display: "Rottweiler", value: "Rottweiler"},
        {display: "Shih Tzu", value: "Shih Tzu"},
        {display: "French Bulldog", value: "French Bulldog"},
        {display: "Siberian Husky", value: "Siberian Husky"}];
    
    var catBreedsUp = [
        {display: "Mixed", value: "Mixed"},
        {display: "Abyssinian", value: "Abyssinian"},
        {display: "American Bobtail", value: "American Bobtail"},
        {display: "American Curl", value: "American Curl"},
        {display: "American Shorthair", value: "American Shorthair"},
        {display: "American Wirehair", value: "American Wirehair"},
        {display: "Balinese", value: "Balinese"},
        {display: "Bengal", value: "Bengal"},
        {display: "Birman", value: "Birman"},
        {display: "Bombay", value: "Bombay"},
        {display: "British Shorthair", value: "British Shorthair"},
        {display: "Burmese", value: "Burmese"},
        {display: "Chartreux", value: "Chartreux"},
        {display: "Colorpoint Shorthair", value: "Colorpoint Shorthair"},
        {display: "Cornish Rex", value: "Cornish Rex"},
        {display: "Devon Rex", value: "Devon Rex"},
        {display: "Egyptian Mau", value: "Egyptian Mau"},
        {display: "Exotic Shorthair", value: "Exotic Shorthair"},
        {display: "Havana Brown", value: "Havana Brown"},
        {display: "Himalayan", value: "Himalayan"},
        {display: "Japanese Bobtail", value: "Japanese Bobtail"},
        {display: "Javanese", value: "Javanese"},
        {display: "Korat", value: "Korat"},
        {display: "Maine Coon", value: "Maine Coon"},
        {display: "Manx", value: "Manx"},
        {display: "Munchkin", value: "Munchkin"},
        {display: "Nebelung", value: "Nebelung"},
        {display: "Norwegian Forest Cat", value: "Norwegian Forest Cat"},
        {display: "Ocicat", value: "Ocicat"},
        {display: "Oriental", value: "Oriental"},
        {display: "Persian", value: "Persian"},
        {display: "Peterbald", value: "Peterbald"},
        {display: "Pixie-Bob", value: "Pixie-Bob"},
        {display: "Ragdoll", value: "Ragdoll"},
        {display: "Russian Blue", value: "Russian Blue"},
        {display: "Savannah", value: "Savannah"},
        {display: "Scottish Fold", value: "Scottish Fold"},
        {display: "Selkirk Rex", value: "Selkirk Rex"},
        {display: "Siamese", value: "Siamese"},
        {display: "Siberian", value: "Siberian"},
        {display: "Singapura", value: "Singapura"},
        {display: "Snowshoe", value: "Snowshoe"},
        {display: "Somali", value: "Somali"},
        {display: "Sphynx", value: "Sphynx"},
        {display: "Tonkinese", value: "Tonkinese"},
        {display: "Toyger", value: "Toyger"},
        {display: "Turkish Angora", value: "Turkish Angora"},
        {display: "Turkish Van", value: "Turkish Van"}];

    var dogBreedsUp = [
        {display: "Mixed", value: "Mixed"},
        {display: "Afghan Hound", value: "Afghan Hound"},
        {display: "Airedale Terrier", value: "Airedale Terrier"},
        {display: "American Eskimo", value: "American Eskimo"},
        {display: "American Pitbull", value: "American Pitbull"},
        {display: "Australian Cattle Dog", value: "Australian Cattle Dog"},
        {display: "Australian Terrier", value: "Australian Terrier"},
        {display: "Bearded Collie", value: "Bearded Collie"},
        {display: "Belgian Malinois", value: "Belgian Malinois"},
        {display: "Belgian Sheepdog", value: "Belgian Sheepdog"},
        {display: "Berger Picard", value: "Berger Picard"},
        {display: "Black Russian Terrier", value: "Black Russian Terrier"},
        {display: "Bloodhound", value: "Bloodhound"},
        {display: "Boxer", value: "Boxer"},
        {display: "Bulldog", value: "Bulldog"},
        {display: "Canaan", value: "Canaan"},
        {display: "Chihuahua", value: "Chihuahua"},
        {display: "Chinook", value: "Chinook"},
        {display: "Chow Chow", value: "Chow Chow"},
        {display: "Collie", value: "Collie"},
        {display: "Dalmation", value: "Dalmation"},
        {display: "Doberman Pinscher", value: "Doberman Pinscher"},
        {display: "Dutch Shepherd", value: "Dutch Shepherd"},
        {display: "English Setter", value: "English Setter"},
        {display: "Pug", value: "Pug"},
        {display: "Labrador Retriever", value: "Labrador Retriever"},
        {display: "Golden Retriever", value: "Golden Retriever"},
        {display: "German Shephered", value: "German Shephered"},
        {display: "Yorkshire Terrier", value: "Yorkshire Terrier"},
        {display: "Poodle", value: "Poodle"},
        {display: "Pomeranian", value: "Pomeranian"},
        {display: "Rottweiler", value: "Rottweiler"},
        {display: "Shih Tzu", value: "Shih Tzu"},
        {display: "French Bulldog", value: "French Bulldog"},
        {display: "Siberian Husky", value: "Siberian Husky"}];

    //If a type is selected, fill the breeds list
    $("#type").change(function () {
        var type = $(this).val();

        switch (type) {
            case 'dog':
                list(dogBreeds);
                break;
            case 'cat':
                list(catBreeds);
                break;
            default:
                $("#breed").html('');
                break;
        }
    });
    
    //If a type is selected, fill the breeds list
    $("#typeUp").change(function () {
        var type = $(this).val();

        switch (type) {
            case 'dog':
                listUp(dogBreedsUp);
                break;
            case 'cat':
                listUp(catBreedsUp);
                break;
            default:
                $("#breedUp").html('');
                break;
        }
    });

    //adds the array to the breed list
    function list(array_list)
    {
        $("#breed").html("");
        $(array_list).each(function (i) {
            $("#breed").append("<option value=\"" + array_list[i].value + "\">" + array_list[i].display + "</option>");
        });
    }
    
    //adds the array to the breed list
    function listUp(array_list)
    {
        $("#breedUp").html("");
        $(array_list).each(function (i) {
            $("#breedUp").append("<option value=\"" + array_list[i].value + "\">" + array_list[i].display + "</option>");
        });
    }

});