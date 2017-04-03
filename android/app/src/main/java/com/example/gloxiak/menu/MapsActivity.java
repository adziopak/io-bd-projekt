package com.example.gloxiak.menu;

import android.support.v4.app.FragmentActivity;
import android.os.Bundle;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

public class MapsActivity extends FragmentActivity implements OnMapReadyCallback {

    private GoogleMap mMap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
    }


    /**
     * Manipulates the map once available.
     * This callback is triggered when the map is ready to be used.
     * This is where we can add markers or lines, add listeners or move the camera. In this case,
     * we just add a marker near Sydney, Australia.
     * If Google Play services is not installed on the device, the user will be prompted to install
     * it inside the SupportMapFragment. This method will only be triggered once the user has
     * installed Google Play services and returned to the app.
     */
    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;

        LatLng budV = new LatLng(50.0188232, 21.9887356);
        LatLng budL = new LatLng(50.0181278, 21.9867635);
        LatLng budP = new LatLng(50.0190398,21.9814866);
        LatLng budH = new LatLng(50.019798, 21.985601);
        LatLng budK = new LatLng(50.019431, 21.985633);
        LatLng budS = new LatLng(50.019204, 21.987532);
        LatLng akad = new LatLng(50.020100, 21.982500);
        LatLng sport = new LatLng(50.018356, 21.980386);
        LatLng budJ = new LatLng(50.019831, 21.980622);
        LatLng budA = new LatLng(50.026934, 21.985086);
        LatLng budB = new LatLng(50.026686, 21.984260);
        LatLng budC = new LatLng(50.026383, 21.983884);
        LatLng budF = new LatLng(50.026031, 21.983348);
        LatLng budD = new LatLng(50.025845, 21.983487);
        LatLng budE = new LatLng(50.026362, 21.984656);
        mMap.addMarker(new MarkerOptions().position(budP).title("Budynek P"));
        mMap.addMarker(new MarkerOptions().position(budL).title("Budynek L"));
        mMap.addMarker(new MarkerOptions().position(budV).title("Budynek V"));
        mMap.addMarker(new MarkerOptions().position(budH).title("Budynek H"));
        mMap.addMarker(new MarkerOptions().position(budK).title("Budynek K"));
        mMap.addMarker(new MarkerOptions().position(budS).title("Budynek S"));
        mMap.addMarker(new MarkerOptions().position(akad).title("Akademiki"));
        mMap.addMarker(new MarkerOptions().position(sport).title("Hala sportowa"));
        mMap.addMarker(new MarkerOptions().position(budJ).title("Budynek J"));
        mMap.addMarker(new MarkerOptions().position(budA).title("Budynek A"));
        mMap.addMarker(new MarkerOptions().position(budB).title("Budynek B"));
        mMap.addMarker(new MarkerOptions().position(budC).title("Budynek C"));
        mMap.addMarker(new MarkerOptions().position(budD).title("Budynek D"));
        mMap.addMarker(new MarkerOptions().position(budE).title("Budynek E"));
        mMap.addMarker(new MarkerOptions().position(budF).title("Budynek F"));
        mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(budV,14));
    }
}
