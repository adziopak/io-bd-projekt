package com.example.gloxiak.menu;

import android.app.Dialog;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.GoogleApiAvailability;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class MapsActivity extends AppCompatActivity implements OnMapReadyCallback {

    GoogleMap mMap;
    GoogleApiClient googleApiClient;
    LocationRequest locationRequest;
    RequestQueue requestQueue;

    //pobrac z jsona zamiast w taki sposob


    String[] buildingNames;
    String[] buildingLatx;
    String[] buildingLngx;

    Double[] buildingLat;
    Double[] buildingLng;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getBuildingsData();
        if (googleServicesAvailable()) {
            setContentView(R.layout.activity_maps);
            initMap();
        }


    }

    public void getBuildingsData() {
        requestQueue = Volley.newRequestQueue(this);

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.GET, "http://skkshowcase.cba.pl/android/buildingList",
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray jsonArray = response.getJSONArray("buildingList");
                            buildingNames= new String[jsonArray.length()];
                            buildingLatx = new String[jsonArray.length()];
                            buildingLngx = new String[jsonArray.length()];


                            for (int i = 0; i < jsonArray.length(); i ++){
                                JSONObject building = jsonArray.getJSONObject(i);
                                String lat = building.getString("lat");
                                buildingLatx[i] = lat;
                            }
                            for (int i = 0; i < jsonArray.length(); i ++){
                                JSONObject building = jsonArray.getJSONObject(i);
                                String name = building.getString("name");
                                buildingNames[i] = "Budynek" + " " + name;
                            }
                            for (int i = 0; i < jsonArray.length(); i ++){
                                JSONObject building = jsonArray.getJSONObject(i);
                                String lng = building.getString("lon");
                                buildingLngx[i] = lng;
                            }
                            buildingLat = new Double[buildingLatx.length];
                            buildingLng = new Double[buildingLngx.length];

                            for (int i = 0 ; i < buildingLatx.length; i ++){
                                buildingLat[i] = Double.parseDouble(buildingLatx[i]);
                            }
                            for (int i = 0 ; i < buildingLngx.length; i ++){
                                buildingLng[i] = Double.parseDouble(buildingLngx[i]);
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("JSONBUILDINGLIST","error");
                    }
                }
        );
        requestQueue.add(jsonObjectRequest);

    }
    public boolean googleServicesAvailable() {
        GoogleApiAvailability api = GoogleApiAvailability.getInstance();
        int isAvailable = api.isGooglePlayServicesAvailable(this);
        if (isAvailable == ConnectionResult.SUCCESS) {
            return true;
        } else if (api.isUserResolvableError(isAvailable)) {
            Dialog dialog = api.getErrorDialog(this, isAvailable, 0);
            dialog.show();
            return false;
        } else {
            Toast.makeText(this, "Nie połączono z play services", Toast.LENGTH_LONG).show();
            return false;
        }
    }

    public void initMap() {
        MapFragment mapFragment = (MapFragment) getFragmentManager().findFragmentById(R.id.mapFragment);
        mapFragment.getMapAsync(this);
    }


    public void showCurrentLocation() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            if (ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
                return;
            }
        }
        mMap.setMyLocationEnabled(true);


    }

    private void goToLocation(double lat, double lng) {
        LatLng latLng = new LatLng(lat, lng);
        CameraUpdate update = CameraUpdateFactory.newLatLngZoom(latLng, 14);
        mMap.moveCamera(update);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        showCurrentLocation();
        goToLocation(buildingLat[0], buildingLng[0]);
        putMarkers();

        mMap.setInfoWindowAdapter(new GoogleMap.InfoWindowAdapter() {
            @Override
            public View getInfoWindow(Marker marker) {
                return null;
            }

            @Override
            public View getInfoContents(Marker marker) {
                View view = getLayoutInflater().inflate(R.layout.info_window, null);
                TextView textView = (TextView) view.findViewById(R.id.nameInfo);
                textView.setText(marker.getTitle());
                return view;
            }
        });
        mMap.setOnInfoWindowClickListener(new GoogleMap.OnInfoWindowClickListener() {
            @Override
            public void onInfoWindowClick(Marker marker) {
                if (marker.getTitle().equals(buildingNames[0])) {
                 //dodac onclicklistenera
                }
            }
        });

    }

    private void putMarkers() {
        for (int i = 0; i < buildingNames.length ; i++) {
            putMarker(buildingNames[i], buildingLat[i], buildingLng[i]);
        }
    }

    private void putMarker(String title, double lat, double lng) {
        MarkerOptions options = new MarkerOptions()
                .title(title)
                .position(new LatLng(lat, lng));
        mMap.addMarker(options);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case R.id.mapTypeNormal:
                mMap.setMapType(GoogleMap.MAP_TYPE_NORMAL);
                break;
            case R.id.mapTypeHybrid:
                mMap.setMapType(GoogleMap.MAP_TYPE_HYBRID);
            default:
                break;
        }
        return super.onOptionsItemSelected(item);
    }

}





