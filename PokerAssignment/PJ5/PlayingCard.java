package PJ5;

import java.util.*;

/*
Header in testPlaySimplePoker
*/


class PlayingCardException extends Exception {

    /* Constructor to create a PlayingCardException object */
    PlayingCardException (){
		super ();
    }

    PlayingCardException ( String reason ){
		super ( reason );
    }
}

class Card {
	
    /* constant suits and ranks */
    static final String[] Suit = {"Clubs", "Diamonds", "Hearts", "Spades" };
    static final String[] Rank = {"","A","2","3","4","5","6","7","8","9","10","J","Q","K"};

    /* Data field of a card: rank and suit */
    private int cardRank;  /* values: 1-13 (see Rank[] above) */
    private int cardSuit;  /* values: 0-3  (see Suit[] above) */

    /* Constructor to create a card */
    /* throw PlayingCardException if rank or suit is invalid */
    public Card(int rank, int suit) throws PlayingCardException { 
	if ((rank < 1) || (rank > 13))
		throw new PlayingCardException("Invalid rank:"+rank);
	else
        	cardRank = rank;
	if ((suit < 0) || (suit > 3))
		throw new PlayingCardException("Invalid suit:"+suit);
	else
        	cardSuit = suit;
    }

    /* Accessor and toString */
    /* You may impelemnt equals(), but it will not be used */
    public int getRank() { return cardRank; }
    public int getSuit() { return cardSuit; }
    public String toString() { return Rank[cardRank] + " " + Suit[cardSuit]; }

    
    /* Few quick tests here */
    public static void main(String args[])
    {
	try {
	    Card c1 = new Card(1,3);    // A Spades
	    System.out.println(c1);
	    c1 = new Card(10,0);	// 10 Clubs
	    System.out.println(c1);
	    c1 = new Card(10,5);        // generate exception here
	}
	catch (PlayingCardException e)
	{
	    System.out.println("PlayingCardException: "+e.getMessage());
	}
    }
}

class Decks {

    //datafields
    private List<Card> originalDecks;   

    private List<Card> dealDecks;

    private int numberDecks;

    //constructors
    public Decks()
    {
        this(1);
    }

    public Decks(int n)
    {
        originalDecks = new ArrayList<>();
        numberDecks = n;
        for( int i = 0; i < numberDecks; i++ ){
            for( int j = 0; j < 4; j++ ){
                for( int h = 1; h <= 13; h++ ){
                    try{
                        originalDecks.add( new Card( h, j ) );
                    }
                    catch( PlayingCardException e ){
                        System.out.println( e );
                    }
                }
            }
        }
        dealDecks = originalDecks;
    }

    //methods
    public void shuffle()
    {
        Collections.shuffle( dealDecks );
    }


    public List<Card> deal( int numberCards ) throws PlayingCardException
    {
        List<Card> temp = new ArrayList<>();
        if( numberCards > remain() )
            throw new PlayingCardException( "You can't deal more cards then the number of cards left." );
        
        for( int i = 0; i < numberCards; i++ ){
            temp.add( dealDecks.remove(0));
        }
        return temp;
    }

    
    public void reset()
    {
        dealDecks = originalDecks;
    }

    
    public int remain()
    {
	return dealDecks.size();
    }

    
    public String toString()
    {
	return ""+dealDecks;
    }

    public static void main(String args[]) {

        System.out.println("*******    Create 2 decks of cards      *********\n\n");
        Decks decks  = new Decks(2);
         
	for (int j=0; j < 2; j++)
	{
        	System.out.println("\n************************************************\n");
        	System.out.println("Loop # " + j + "\n");
		System.out.println("Before shuffle:"+decks.remain()+" cards");
		System.out.println("\n\t"+decks);
        	System.out.println("\n==============================================\n");

                int numHands = 4;
                int cardsPerHand = 30;

        	for ( int i = 0; i < numHands; i++ )
	 	{
	    		decks.shuffle();
		        System.out.println("After shuffle:"+decks.remain()+" cards");
		        System.out.println("\n\t"+decks);
			try {
            		    System.out.println("\n\nHand "+i+":"+cardsPerHand+" cards");
            		    System.out.println("\n\t"+decks.deal(cardsPerHand));
            		    System.out.println("\n\nRemain:"+decks.remain()+" cards");
		            System.out.println("\n\t"+decks);
        	            System.out.println("\n==============================================\n");
			}
			catch (PlayingCardException e) 
			{
		 	        System.out.println("*** In catch block : PlayingCardException : msg : "+e.getMessage());
			}
		}
		decks.reset();
	}
    }

}
